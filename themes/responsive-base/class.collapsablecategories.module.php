<?php
/**
 * Jump to Categories Module
 *
 * @copyright 2009-2017 Vanilla Forums Inc.
 * @license proprietary http://vanillaforums.com
 * @since 1.0
 */

/**
 * Renders the discussion categories.
 */
class CollapsableCategoriesModule extends Gdn_Module {

    public $startDepth = 1;

    public $endDepth = 4;

    public $collapseCategories = false;

    /**
     * Override __construct function.
     *
     * @param Gdn_Controller $sender            The controller instantiating the module
     * @param boolean        $ApplicationFolder The folder to server resources out of.
     */
    public function __construct($sender = '', $ApplicationFolder = false) {
        $themeLocation = paths(
            PATH_THEMES,
            Gdn::addonManager()->getTheme()->getKey()
        );
        parent::__construct($sender, $themeLocation);
    }

    /**
     * The target asset to be rendered to if not called in a template.
     *
     * @return string
     */
    public function assetTarget() {
        return 'Panel';
    }

    /**
     * Get the data for this module.
     *
     * @return array An array of categories with their children attatched.
     */
    protected function buildCategoryTree() {
        $categories = CategoryModel::instance()
            ->getChildTree(-1, [
                'collapseCategories' => $this->collapseCategories,
                'maxDepth' => $this->endDepth
            ]);

        // $this->filterDepth($categories, $this->startDepth, $this->endDepth);
        $categories = $this->getCategoriesWithCorrectedUrls($categories);

        if (c('Categories.Accordian.ShowHeading', true)) {
            $categories = [[
                'Children' => $categories,
                'Archived' => 0,
                'Name' => t('Categories'),
                'Depth' => 0,
                'Url' => Gdn_Theme::link('categories', false, '%url')
            ]];
        }

        return $categories;
    }

    public function filterDepth(&$Categories, $startDepth, $endDepth) {
        if ($startDepth != 1 || $endDepth) {
            foreach ($Categories as $i => $category) {
                if (val('Depth', $category) < $startDepth || ($endDepth && val('Depth', $category) > $endDepth)) {
                    unset($Categories[$i]);
                }
            }
        }
    }

    public function getCategoriesWithCorrectedUrls($categories) {
        $results = [];
        if (class_exists('SubcommunitiesPlugin')) {
            foreach ($categories as $category) {
                $category['Url'] = $this->getSubcommunityUrlForCategory($category);
                $url = val('Url', $category);
                if (val('Children', $category)) {
                    $correctedChildren = $this->getCategoriesWithCorrectedUrls(val('Children', $category));
                    setValue('Children', $category, $correctedChildren);
                }
                $results []= $category;
            }
        } else {
            $results = $categories;
        }

        return $results;
    }

    public function getSubcommunityUrlForCategory($category) {
        if (class_exists('SubcommunitiesPlugin')) {
            if (val('Depth', $category) === 1) {
                $subcommunity = SubcommunitiesPlugin::getSubcommunityFromCategoryID($category['CategoryID']);
                return "/{$subcommunity['Folder']}/";
            } else {
                $subcommunity = SubcommunitiesPlugin::getSubcommunityFromCategoryID($category['ParentCategoryID']);
                $targetWebRoot = "/{$subcommunity['Folder']}/";

                return $targetWebRoot.'categories/'.val('UrlCode', $category);
            }
        } else {
            return val('UrlCode', $category);
        }
    }


    /**
     * Redner string of the module.
     *
     * @return string
     */
    public function toString() {
        $this->setData('Categories', $this->buildCategoryTree());

        return parent::toString();
    }
}
