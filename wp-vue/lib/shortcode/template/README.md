# Template

To make it easy and simple to the admin user, I create the following shortcode that is normally used to insert complex PHP code snippets (like integrated forms or calculators) in the pages.

Includes a PHP file in the page. Imagine you want to embed `inc/form-test.php` (located in the theme root) in the page.

So you can do this using a simple shortcode

```
[template name="inc/form-test"]
```

that will translate to the WordPress function

```
<?php get_template_part('inc/form-test'); ?>
```
