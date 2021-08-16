import './styles/app.css';

const $ = require('jquery');

import Swup from 'swup';
import SwupTheme from '@swup/fade-theme';
const swup = new Swup({
    plugins: [
        new SwupTheme()
    ],
});

$(document).on('change', '#user_search_parent_tag', function () {
    displayPublicationTagByParent();
});

function displayPublicationTagByParent()
{
    let $userSearchParentTag = $('#user_search_parent_tag');
    if ($userSearchParentTag === 'undefined') {
        return;
    }
    let $form = $(this).closest('form');
    let data = {};
    let spin = $('#spin');
    let $userSearchPublication = $('#user_search_publication');

    spin.removeClass('d-none');
    $userSearchPublication.addClass('d-none')
    data[$(this).attr('name')] = $(this).val();
    data[$userSearchParentTag.attr('name')] = $userSearchParentTag.val();
    $.get($form.attr('action'), data)
        .done(function (html) {
            $userSearchPublication.removeClass('d-none');
            $userSearchPublication.replaceWith($(html).find('#user_search_publication'));
            spin.addClass('d-none');
        });
}

displayPublicationTagByParent();
