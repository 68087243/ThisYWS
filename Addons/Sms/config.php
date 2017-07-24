<?php

return array(
    'status'=>array(
        'title'=>'是否开启短信:',
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
                'title'=>'短信设置',
                'options'=>array(
                    'APP_KEY'=>array(
                        'title'=>'App Key：',
                        'type'=>'text',
                        'value'=>'',
                        'tip'=>'阿里大鱼app Key：',
                    ),
                    'APP_SECRET'=>array(
                        'title'=>'App secret：',
                        'type'=>'text',
                        'value'=>'',
                        'tip'=>'阿里大鱼app secret',
                    ),
					'APP_SIGN'=>array(
                        'title'=>'App Id：',
                        'type'=>'text',
                        'value'=>'',
                        'tip'=>'阿里大鱼短信签名',
                    ),
					'TEMPLATE_ID'=>array(
                        'title'=>'Template Id：',
                        'type'=>'text',
                        'value'=>'',
                        'tip'=>'阿里大鱼模板ID',
                    ),
                ),
             ),
            'template'=>array(
                'title'=>'发信模版',
                'options'=>array(
                    'default'=>array(
                        'title'=>'发信模版：',
                        'type'=>'textarea',
                        'value'=>'',
                        'tip'=>'默认发信模版',
                    )
                )
            )
        )
    )
);
