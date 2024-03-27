# Clinical Trials CPT

This plugin creates a custom post type for clinical trials and adds a block for displaying a listing of clinical trials on the front-end. The listing of trials can be limited to specified categories using a toggle in the block editor.

## Installation

* Download the latest release from this GitHub repo, and upload the plugin through the WordPress plugins screen directly.
* Activate the plugin through the 'Plugins' screen in WordPress
* Create and assign clinical trial posts to specific categories
* Use the Clinical Trials Listing block in the block editor to display the clinical trials on the front-end

## Features

* Custom post type for clinical trials
* Block for displaying clinical trial listing on the front-end
* Option to limit trial listing to specified categories in the block editor

## Usage

1. In the WordPress dashboard, navigate to the 'Clinical Trials' post type and add new trial posts.
2. Assign the trial posts to specific categories
3. In the post or page where you want to display the trial listing, add the Clinical Trials Listing block.
4. Use the toggle in the block editor to specify whether to limit the listing to certain categories
5. Publish or update the post or page to display the clinical trial listing on the front-end.

## Contribution

This plugin is open-source and welcomes contributions from the community. If you would like to contribute, please fork the repository and submit a pull request with your changes.
Support

Please file any issues in the GitHub repository.

## Changelog

### 1.0

* Initial release
* Custom post type for clinical trials
* Block for displaying clinical trial listing on the front-end
* Option to limit trial listing to specified categories in the block editor

### 1.4.0

* Fix category whitelist
* Add UCF Health template page to show acf fields on
* If multisite, switch_to_blog to 1, as we only use the main site for trial info

### 1.4.1
* Fix multisite - only show post type on main site, but register taxonomy for subsites
