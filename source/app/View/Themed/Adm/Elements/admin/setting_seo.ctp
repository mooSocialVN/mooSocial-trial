<div style="padding: 10px;">
<button style="position: absolute;right: 20px;" class="btn btn-gray" onclick='window.location.href = "<?php echo $this->request->base ?>/admin/layout";'><?php echo __('SEO Settings'); ?></button>
<p><strong>1. Browser Pages and general pages (Blogs, Topics, People, Home, Landing page, contact, term of service........)</strong></p>

<p>&lt;title&gt; <span class="error">&#91;page title in layout editor&#93;</span> | <span class="error">&#91;site title&#93;</span> &lt;/title&gt;<br/>
    &lt;meta name="description" content="first 40 words of page description in layout editor OR Site's descripiton if page descrption is empty"/&gt;<br/>
    &lt;meta name="robots" content="index,follow" /&gt;<br/>
    &lt;meta name="keywords" content="page keywords in layout editor, separated by comma OR Site's keywords if page keywords is empty" /&gt;<br/>
    &lt;meta property="og:site_name" content="Site name" /&gt;<br/>
    &lt;meta property="og:title" content="page title in layout editor" /&gt;<br/>
    &lt;meta property="og:image" content="url image of site's og" /&gt;<br/>
    &lt;meta property="og:url" content="current url" /&gt;<br/>
    &lt;h1&gt; item title	&lt;/h1&gt;  - NONE</p>

<p><strong>2. For details page such as topic details, blogs, groups.....</strong></p>

<p>&lt;title&gt; <span class="error">&#91;item title&#93;</span> | <span class="error">&#91;site title&#93;</span> &lt;/title&gt;<br/>
    &lt;meta name="description" content="first 40 words of item description"/&gt;</p>

<p>If viewer can't view "item description" field because of privacy or description field is empty --> Description should be description in layout editor
<br>
If viewer can't view "item description" field because of privacy or description field is empty and description in layout editor is empty --> Description should be site's description</p>

<p>&lt;meta name="robots" content="index,follow" /&gt;<br/>
    &lt;meta name="keywords" content="item tags + description, separated by comma" /&gt;</p>

<p>If viewer can't view "item description" field because of privacy or description field is empty --> Keywords should be keywords in layout editor
<br>
If viewer can't view "item description" field because of privacy or description field is empty and keywords in layout editor is empty --> Keywords should be site's keywords</p>


<p>&lt;meta property="og:site_name" content="Site name" /&gt;<br/>
    &lt;meta property="og:title" content="item title" /&gt;<br/>
    &lt;meta property="og:image" content="url image of item OR site's og if item does not have image" /&gt;<br/>
    &lt;meta property="og:url" content="url of item" /&gt;<br/>
    &lt;h1&gt; item title	&lt;/h1&gt;</p>

<p><strong>3. For member profile</strong></p>

<p>&lt;title&gt; <span class="error">&#91;Full name&#93;</span> | <span class="error">&#91;site title&#93;</span> &lt;/title&gt;<br/>
    &lt;meta name="description" content="first 40 words about field OR Site's description if about field is empty "/&gt;</p>

<p>If viewer can't view "About" field because of privacy or About field is empty -&gt; Description should be site's description</p>

<p>&lt;meta name="robots" content="index,follow" /&gt;</p>

<p>&lt;meta name="keywords" content="about field, separated by comma  OR Site's keywords if about field is empty" /&gt;</p>

<p>If viewer can't view "About" field because of privacy or about field is empty -&gt; keywords should be site's keywords</p>

<p>&lt;meta property="og:site_name" content="Site name" /&gt;<br/>
    &lt;meta property="og:title" content="Full name" /&gt;<br/>
    &lt;meta property="og:image" content="url image of member avatar" /&gt;</p>

<p>Member does not have image -> use site's og</p>

<p>&lt;meta property="og:url" content="url of member profile" /&gt;<br/>
    &lt;h1&gt; Full name &lt;/h1&gt;</p>
</div>