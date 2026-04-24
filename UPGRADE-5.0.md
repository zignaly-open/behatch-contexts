Upgrade from 4.x to 5.0
========================

5.0 raises the floor to **PHP 8.4** and **Symfony 6.4 LTS**, drops every
older PHP and Symfony version, removes the abandoned Goutte dev-dep, and
modernizes the codebase with Rector.

## Breaking changes

### Runtime requirements

| Requirement | 4.x | 5.0 |
|-------------|-----|-----|
| PHP         | `>=5.5` | `^8.4` |
| `symfony/*` (property-access, http-foundation, dom-crawler) | `^2.3 \| ^3.0 \| ^4.0 \| ^5.0 \| ^6.0` | `^6.4.29` (closes GHSA-3rg7-wf37-54rm + GHSA-mrqx-rp3w-jpjp) |
| `behat/behat` | `^3.0.13` | `^3.15` |
| `friends-of-behat/mink-extension` | `^2.3.1` | `^2.7` |
| `justinrainbow/json-schema` | `^5.0` | `^6.5` |

### Goutte session removed

`fabpot/goutte` and `behat/mink-goutte-driver` are abandoned upstream and
did not work on PHP 8.4. Both are gone from `require-dev`.

If your `behat.yml` used `session: symfony2` (which behatch historically
wired to a Goutte-backed `Behatch\HttpCall\Request\Goutte`), you will now
see:

```
InvalidArgumentException: The 'symfony2' session alias was removed in
behatch/contexts 5.0 (fabpot/goutte is abandoned). Update your behat.yml
to 'session: default' and use behat/mink-browserkit-driver.
```

Migration: swap your Mink configuration to `behat/mink-browserkit-driver`
(backed by `symfony/browser-kit` + `symfony/http-client`). The Mink
session API is unchanged.

```yaml
# behat.yml — before
default:
    extensions:
        Behat\MinkExtension:
            sessions:
                symfony2:
                    goutte: ~

# behat.yml — after
default:
    extensions:
        Behat\MinkExtension:
            sessions:
                default:
                    browserkit_http: ~
```

In `composer.json`:

```diff
 "require-dev": {
-    "behat/mink-goutte-driver": "^1.1",
-    "fabpot/goutte":            "^3.2",
+    "behat/mink-browserkit-driver": "^2.3",
+    "symfony/browser-kit":          "^6.4",
+    "symfony/http-client":          "^6.4"
 }
```

### atoum 2.x/3.x → 4.x

If you inherited behatch's atoum setup and have `mageekguy\atoum\*`
references anywhere (config files, custom extensions), rename to
`atoum\atoum\*`. Test classes extending `\atoum` work unchanged — the
short alias is preserved.

### json-schema 5.x → 6.5

The package name is unchanged (`justinrainbow/json-schema`). API-level
callers of `Validator::validate()`, `SchemaStorage`, `UriRetriever`,
`UriResolver` are compatible. The only forced change is if you read
`$error['constraint']` from `Validator::getErrors()`:

```diff
 foreach ($validator->getErrors() as $error) {
-    $name = $error['constraint'];          // v5: string, e.g. 'required'
+    $name = $error['constraint']['name'];  // v6: nested, 'name' + 'params'
 }
```

Subclasses of `BaseConstraint` that call `addError()` must adopt the new
signature with a `ConstraintError` enum case as the first argument.

### Rector-applied code changes

PHP 8.4 + Symfony 6.4 Rector sets were applied across `src/` and
`tests/units/`. Public API is unchanged. Notable internal changes:
constructor property promotion, readonly properties, explicit return
types, removed unused catch variables, `declare(strict_types=1)` added
to every file. Downstream subclasses of our context classes may see
narrowed parameter/return types — adjust signatures accordingly.

### `readonly` on promoted constructor properties (subclass BC note)

Every context class and helper that receives its dependency via the
constructor now uses `readonly` on the promoted property: `Request::$mink`,
`BrowserKit::$mink`, `RestContext::$request`, `JsonContext::$httpCallResultPool`,
`BrowserContext::$timeout`, `DebugContext::$screenshotDir`,
`SystemContext::$root`, `HttpCallListener::$contextSupportedVoter` / `$httpCallResultPool` / `$mink`.

**Subclass impact:** if your own class extends one of these and overrides
the constructor, you must:

1. Preserve the `readonly` promoted-parameter modifier when calling
   `parent::__construct(...)`, OR
2. Never reassign `$this->mink` (or similar) in the child class —
   `readonly` fails at runtime on reassignment.

Example downstream fix:

```php
// 4.x — worked:
class CustomRestContext extends RestContext {
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->request = new CustomRequestWrapper($request); // no longer allowed
    }
}

// 5.0 — use composition or extend the wrapper itself:
class CustomRestContext extends RestContext {
    public function __construct(Request $request) {
        parent::__construct(new CustomRequestWrapper($request));
    }
}
```

If your fork genuinely needs mutability, remove `readonly` in a local
patch and track the deviation separately.

## Supported versions going forward

Only the 5.x line is maintained. The 4.x line is frozen.
