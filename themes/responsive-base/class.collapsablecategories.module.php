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

    public $showAllSubcommunities = false;

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

        $categories = $this->adjustCategoriesForSubcommunities($categories);

        if ($this->showAllSubcommunities) {
            $categories = [[
                'Children' => $categories,
                'Archived' => 0,
                'Name' => t('Categories'),
                'Depth' => 'top',
                'Url' => Gdn_Theme::link('categories', false, '%url')
            ]];
        } else {
            $categories[0]['Name'] = t('Categories');
            $categories[0]['Url'] = Gdn_Theme::link('categories', false, '%url');
            $categories[0]['Depth'] = 'top';
        }

        return $categories;
    }

    /**
     * Restructure the URLs if subcommunities are enabled.
     *
     * @param array $categories An array of categories to remap
     *
     * @return array
     */
    public function adjustCategoriesForSubcommunities($categories) {
        if (class_exists('SubcommunitiesPlugin')) {
            $results = [];
            $currentSubcommunityCategoryID = val('CategoryID', SubcommunityModel::getCurrent());
            foreach ($categories as $category) {
                $category['Url'] = $this->getSubcommunityUrlForCategory($category);
                $url = val('Url', $category);

                if ($this->showAllSubcommunities
                    || val('Depth', $category) !== 1
                    || val('CategoryID', $category) === $currentSubcommunityCategoryID
                ) {
                    if (val('Children', $category)) {
                        $correctedChildren = $this->adjustCategoriesForSubcommunities(val('Children', $category));
                        setValue('Children', $category, $correctedChildren);
                    }

                    $results []= $category;
                }
            }
            if (!$this->showAllSubcommunities) {
                $results = $results;
            }

            return $results;
        } else {
            return $categories;
        }
    }

    /**
     * Filter to just the current subcommunity unless a config setting is set.
     *
     * @param array $categories The categories to filter
     *
     * @return array The potentially filtered categories
     */
    public function filterCurrentSubcommunity($categories) {
        if (class_exists('SubcommunitiesPlugin')) {
             $currentSubCommunity = SubcommunityModel::getCurrent();
        }
    }

    /**
     * If subcommunities are enabled we need make subcommuntiy URLs for the dropdown
     *
     * @param array $category The category to get the URL of
     *
     * @return string The URL in the form /[subcommunity]/categories/category or
     */
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
