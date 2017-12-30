# html-generator

Simple PHP class for automatic html content generation. Example:

```
    Html::div()
        ->class("section")
        ->content(
            Html::div()
            ->class("baloon")
            ->content(
                Html::header("Title"),
                Html::p("Paragraph")
            )
        )->show();
```

Output:

```
    <div class="section">
        <div class="baloon">
            <header>
                Title
            </header>
            <p>
                Paragraph
            </p>
        </div>
    </div>
```

Using magic call method you can call any tag (for example to spawn `<h1>` you need to run `Html::h1()`. Also you can set any property you want - if you need to set `class` to `"x"` you call method `->class("x")`, if you need to set `abc` property to `cde` you call `->abc("cde")` and so on. Class automatically checks if tag is self-closing or not. Also intendation is proper to W3C HTML5 standard. For now I wrote only body generation, without any headers, styles or opening `<!doctype html>` tags etc.

If you need to remove any formatting (for example in `textarea`), you can use a `->dontFormat()` method.

Added option for disabled quotations.