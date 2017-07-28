<?php
/**
 * Collapsable Category Module
 *
 * @author Adam Charron <adam.c@vanillaforums.com>
 * @copyright 2009-2017 Vanilla Forums Inc.
 * @license Proprietary http://vanillaforums.com
 * @since 1.0
 */

echo "<ul class='CategoriesModule PanelCategories'>";

foreach ($this->data('Categories', []) as $category) {
    renderCategoryItem($category);
}
echo "</ul>";

/**
 * Render a single catgeory and its children.
 *
 * @param Category $category The category to be rendered.
 *
 * @return void
 */
function renderCategoryItem($category) {
    if (val('Archived', $category) > 0) {
        return;
    }

    $hasChildren = count(val('Children', $category)) > 0;

    // Classes applied to each Item.
    $itemClassesArray = [
        'CategoriesModule-category',
        'isDepth-'.val('Depth', $category),
        val('CssClass', $category)
    ];

    $itemClasses = implode(' ', $itemClassesArray);
    $name = htmlspecialchars(val('Name', $category));
    $url = htmlspecialchars(val('Url', $category));

    // Echo out structure.

    echo "<li class='$itemClasses'>";

    if ($hasChildren) {
        echo "<div class='CategoriesModule-categoryWrap CategoriesModule-collapse'>";
        echo "<a href='$url' class='CategoriesModule-title'>$name</a>";
        echo "<span class='CategoriesModule-chevron'></span>";
    } else {
        echo "<div class='CategoriesModule-categoryWrap'>";
        echo "<a href='$url' class='CategoriesModule-title'>$name</a>";
    }
    echo "</div>";

    // Map out child categories.
    if ($hasChildren) {
        echo "<ul class='CategoriesModule-children'>";
        foreach (val('Children', $category) as $child) {
            renderCategoryItem($child);
        }
        echo "</ul>";
    }
    echo "</li>";
}
