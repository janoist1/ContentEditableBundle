# ContentEditableBundle
Simple and flexible WYSIWYG editor bundle for Symfony - works well with Ist1ContentBundle


### Install

1. add to composer
    ```sh
    $ composer require ist1/content-editable-bundle
    ```

2. update your AppKernel:
    ```php
    new Ist1\ContentEditableBundle\Ist1ContentEditableBundle(),
    ```

3. get Aloha editor (http://www.alohaeditor.org/) and install it

4. update your config.yml with something like this:
    ```
    ist1_content_editable:
        configurations:
            # with an every day regular entity
            acme_blog:
                repository_class: AcmeSampleBundle:Blog
            # with Ist1ContentBundle
            ist1_content:
                repository_class: Ist1ContentBundle:Content
                id_field: name
                data_field: content
```

5. update your routing.yml:
    ```
    ist1_content_editable:
        resource: "@Ist1ContentEditableBundle/Controller/"
        type:     annotation
        prefix:   /admin/content-editable
    ```
6. include JS: '@Ist1ContentEditableBundle/Resources/public/js/main.js'

7. invoke init function by passing a base url somehow like this:
    ```javascript
    contentEditable.init('/' + locale + '/admin/content-editable');
    ```

8. (optional) include CSS. '@Ist1ContentEditableBundle/Resources/public/css/main.css'

### Usage


- sample twig code:

```
<p {{ content_editable ('acme_blog', blog.id, 'lead') }}>{{ blog.lead }}</p>
```

- sample twig code with Ist1ContentBundle:

```
<p {{ content_editable ('ist1_content', 'id_of_the_content') }}>{{ content ('id_of_the_content', 'initial value of the content') }}</p>
```

- once you have initialised ContentEditable you'll just need to activate the Aloha editor by clicking on the element you want to edit

### Appendix

- this is a very early version, just decoupled from one of my recent projects
- I'll improve it when a future project requires me to add more functionality
- test coverage is coming soon
- function signature: content_editable (configKey, objectId, dataField = null)

