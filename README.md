# ContentEditableBundle
WYSIWYG editor bundle for Symfony - works well with ContentBundle

- utilises Aloha editor (http://www.alohaeditor.org/)

- sample twig code:
<p {{ content_editable ('configuration', 'id_of_the_content') }}>{{ content ('id_of_the_content', 'value of the content') }}</p>

- sample configuration:

ist1_content_editable:
    configurations:
        # with ContentBundle
        content:
            repository_class: Ist1ContentBundle:Content
            id_field: name
            data_field: content
        # with a usual entity
        service:
            repository_class: Ist1AppBundle:Blog
