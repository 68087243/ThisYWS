<?php

return array(
    'status'=>array(
        'title'=>'是否开启畅言评论:',
        'type'=>'radio',
        'options'=>array(
            '1'=>'开启',
            '0'=>'关闭',
        ),
        'value'=>'1',
    ),
    'group'=>array(
        'type'=>'group',
        'options'=>array(
            'server'=>array(
                'title'=>'单点登录',
                'options'=>array(
                    'APP_ID'=>array(
                        'title'=>'APP ID：',
                        'type'=>'text',
                        'value'=>'',
                        'tip'=>'畅言APP ID',
                    ),
                    'APP_KEY'=>array(
                        'title'=>'APP KEY：',
                        'type'=>'text',
                        'value'=>'',
                        'tip'=>'畅言APP KEY',
                    )
                ),
             ),
            'code'=>array(
                'title'=>'评论代码',
                'options'=>array(
                    'changyancode'=>array(
                        'title'=>'评论代码',
                        'type'=>'textarea',
                        'value'=>'',
                        'tip'=>'畅言评论代码',
                    )
                )
            )
        )
    )
);
