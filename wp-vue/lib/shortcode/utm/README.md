# UTM and MCID query strings

If one of the following parameters is passed as query string it will be cached in a cookie and kept for 7 days
- utm_source
- utm_medium
- utm_campaign
- utm_term
- utm_content
- mcid

If for any reason you need to display or use one of those value you can use the following shortcodes:
- `[utm_source]`
- `[utm_medium]`
- `[utm_campaign]`
- `[utm_term]`
- `[utm_content]`
- `[mcid]`

For PHP hackers there are some global variables available as replacement of the shortcodes:

```php
global $my_utm_source;
global $my_utm_medium;
global $my_utm_campaign;
global $my_utm_term;
global $my_utm_content;
```

or some PHP functions that return the current value stored in the cookies or the default one.

```php
my_utm_source_tracking()
my_utm_medium_tracking()
my_utm_campaign_tracking()
my_utm_term_tracking()
my_utm_content_tracking()
```

The default value can be alter passing a new value to the function:

```php
my_utm_source_tracking($new_default)
my_utm_medium_tracking($new_default)
my_utm_campaign_tracking($new_default)
my_utm_term_tracking($new_default)
my_utm_content_tracking($new_default)
```
