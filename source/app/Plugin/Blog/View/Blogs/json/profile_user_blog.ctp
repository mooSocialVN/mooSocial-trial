<?php

$v = '';

if ($data['page'] > 1)
    $v = $this->render('/Elements/lists/blogs_list');
else
    $v = $this->render('Blog.Blogs/profile_user_blog');

echo json_encode(
        array('data' => $v,
            'error' => null,
        )
);
