<?php
    $entries = array();
    if (count($blogs) > 0) {
        $i = 0;
        foreach ($blogs as $blog) {
            $entries[] = array(
                'href' => $this->request->base . '/blogs/view/' . $blog['Blog']['id'] . '/' . seoUrl($blog['Blog']['title']),
                'img' => (($blog['Blog']['thumbnail']) ? ($this->request->base . '/' . $blog['Blog']['thumbnail']) : ($this->request->base . '/img/noimage/noimage-blog.png')),
                'comment_count' => $blog['Blog']['comment_count'],
                'title' => $blog['Blog']['title'],
                'intro' => $this->Text->truncate(strip_tags(str_replace(array('<br>', '&nbsp;'), array(' ', ''), $blog['Blog']['body'])), 150, array('exact' => false)),
                'owner' => $this->Moo->getName($blog['User'], false),
                'created' => $this->Moo->getTime($blog['Blog']['created'], Configure::read('core.date_format'), $utz)

            );
        }
    }
    $data = array(
        'blogs'=>$entries,
        'translate'=>array(
            'posted_by'=>__('Posted by'),
            'no_more_results_found'=>__('No more results found'),
        ),
    );

/*
    echo json_encode(
        array('data' => $data,
            'error' => null,
        )
    );
*/
echo json_encode($entries,JSON_UNESCAPED_UNICODE);
        ?>

