<?php

function demoteHtmlHeaderTags($html)
{
    $originalHeaderTags = [];
    $demotedHeaderTags = [];
    foreach (range(100, 1) as $index) {
        $originalHeaderTags[] = '<h'.$index.'>';
        $originalHeaderTags[] = '</h'.$index.'>';
        $demotedHeaderTags[] = '<h'.($index + 2).'>';
        $demotedHeaderTags[] = '</h'.($index + 2).'>';
    }
    return str_ireplace($originalHeaderTags, $demotedHeaderTags, $html);
}

function markdownToDemotedHtml($markdown)
{
    return demoteHtmlHeaderTags(\Markdown::convertToHtml($markdown));
}