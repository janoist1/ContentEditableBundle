# ContentEditableBundle
WYSIWYG editor bundle for Symfony - works well with ContentBundle

- utilises Aloha editor (http://www.alohaeditor.org/)

- signature: content_editable (configKey, objectId, dataField = null)

- sample twig code:
```
<p {{ content_editable ('blog', blog.id, 'content') }}>{{ blog.content }}</p>
```

- sample twig code with ContentBundle:
```
<p {{ content_editable ('content', 'id_of_the_content') }}>{{ content ('id_of_the_content', 'initial value of the content') }}</p>
```

- sample configuration:

```
ist1_content_editable:
    configurations:
        # with ContentBundle
        content:
            repository_class: Ist1ContentBundle:Content
            id_field: name
            data_field: content
        # with a usual entity
        blog:
            repository_class: Ist1AppBundle:Blog
```
