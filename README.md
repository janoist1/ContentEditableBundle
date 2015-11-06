# ContentEditableBundle
WYSIWYG editor bundle for Symfony - works well with ContentBundle


### Install

1. add to composer
```
$ composer require ist1/content-editable-bundle
```
2. get Aloha editor (http://www.alohaeditor.org/) and install it

3. update your config.yml with something like this:
```
    ist1_content_editable:
        configurations:
            # with a usual entity
            blog:
                repository_class: Ist1AppBundle:Blog
            # with Ist1ContentBundle
            content:
                repository_class: Ist1ContentBundle:Content
                id_field: name
                data_field: content
```

### Usage


- sample twig code:

```
<p {{ content_editable ('blog', blog.id, 'content') }}>{{ blog.content }}</p>
```

- sample twig code with Ist1ContentBundle:

```
<p {{ content_editable ('content', 'id_of_the_content') }}>{{ content ('id_of_the_content', 'initial value of the content') }}</p>
```

### Appendix

- this is a very early version, just decoupled from one of my recent projects
- I'll improve it when a future project requires me to add more functionality
- test coverage is coming soon
- function signature: content_editable (configKey, objectId, dataField = null)

