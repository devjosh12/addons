<?php if (!defined('APPLICATION')) {exit();}
/**
 * Responsive Base ThemeHooks.
 *
 * @author    Adam Charron <adam.c@vanillaforums.com>
 * @copyright 2009-2017 Vanilla Forums Inc.
 * @license   GPLv2
 * @since     1.0.0
 */

/**
 * Ovarian Canada ThemeHooks.
 */
class ResponsiveThemeHooks extends Gdn_Plugin {

    /**
     * Run once on enable.
     *
     * @return void
     */
    public function setup() {
        saveToConfig([
            'Garden.MobileTheme' => 'ovariancanada'
        ]);
        $this->structure();
    }

    /**
     * Run on utility/update.
     *
     * @return void
     */
    public function structure() {
        saveToConfig([
            'Routes.DefaultController' => ['categories', 'Internal'],
            'Garden.Thumbnail.Size' => '200'
        ]);
    }

    /**
     * Runs every page load
     *
     * @param Gdn_Controller $sender This could be any controller
     *
     * @return void
     */
    public function base_render_before($sender) {
    }
}
