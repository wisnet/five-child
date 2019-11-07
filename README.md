# wisnet Five Child Starter
This is the child theme to *[wisnet Five](https://github.com/wisnet/five)*. You should checkout the readme over there :)

## Requirements
* PHP 7.2
* Composer
* NPM

## Technologies
* PHP 7.2
* WP >5.0
* [Timber](https://www.upstatement.com/timber/) (Plugin)
* Advanced Custom Fields >5.8.0-beta3 (Plugin)
* Composer
* NPM
* Webpack
* ES2015
* HTML5
* CSS3
* [Bootstrap 4.2](https://getbootstrap.com/docs/4.2/getting-started/introduction/)


## Custom Post Types
Any new custom post types need to reside in `inc/custom-post-types.php`

## Custom Taxonomies
Any new custom taxonomies need to reside in `inc/custom-taxonomies.php`

## Custom Fields (ACF)
You can create the custom fields using ACF's editor. Make sure the `acf-json` directory exists so those fields can be saved to that directory. This way when pushing to the production site the fields will not need to be re-created!

## SCSS
All SCSS must be broken up in a logical way so that we are not creating one large SCSS file that is difficult to read through. We utilize [Atomic Doc](http://atomicdocs.io/) which uses the [Atomic Design](https://bradfrost.com/blog/post/atomic-web-design/) principle to help us with this.

### SCSS/JS Build
To compile the SCSS/JS run `npm run watch` while in *developement* while in the `/wp-content/themes/five-child` directory. For *production* run `npm run production`.
