<?php

namespace Common\Builder;
use Think\View;
use Think\Controller;
/**
 * 数据列表自动生成器
 * @author c0de <47156503@qq.com>
 */
class EchartsBuilder extends Controller{
    private $_title; //页面标题
    private $_url; //表单提交地址
    private $_form_items = array(); //表单项目
    private $_form_data = array(); //表单数据
	private $_echarts_field= array();//字段
	private $_echarts_category="'_T3T2_'";
	private $_echarts_legend="'_T3T2_'";
	private $_echarts_title;
    private $_template = 'Builder/echartsbuilder'; //模版

    /**设置页面标题
     * @param $title 标题文本
     * @return $this
     */
    public function title($title){
        $this->meta_title = $title;
        return $this;
    }
	
	public function addTitle($title){
		$this->_echarts_title=$title;
		 return $this;
	}
	
	public function addCategory($Category){
		foreach($Category as $val){
			$this->_echarts_category.=",'".$val."'";
		}
        return $this;
	}
	
	public function addField($name,$data){
		$this->_echarts_legend.=",'".$name."'";
		$_temp="'_T3T2_'";
		if(in_array){
			foreach($data as $val){
				$_temp.=",'".$val."'";
			}
		}else{
			$_temp.=',';
		}
		$this->_echarts_field[]=Array('name'=>$name,'data'=>str_replace("'_T3T2_',","",$_temp));
		return $this;
	}

   

    /**设置表单提交地址
     * @param $url 提交地址
     * @return $this
     */
    public function setUrl($url){
        $this->_url = $url;
        return $this;
    }

    /**加入一个表单项
     * @param $type 表单类型(取值参考系统配置FORM_ITEM_TYPE)
     * @param $title 表单标题
     * @param $tip 表单提示说明
     * @param $name 表单名
     * @param $options 表单options
     * @param $extra_class 表单项是否隐藏
     * @param $extra_attr 表单项额外属性
     * @return $this
     */
    public function addItem($name, $type, $title, $tip, $options = array(), $extra_class = '', $extra_attr = ''){
        $item['name'] = $name;
        $item['type'] = $type;
        $item['title'] = $title;
        $item['tip'] = $tip;
        $item['options'] = $options;
        $item['extra_class'] = $extra_class;
        $item['extra_attr'] = $extra_attr;
        $this->_form_items[] = $item;
        return $this;
    }

    /**设置表单表单数据
     * @param $form_data 表单数据
     * @return $this
     */
    public function setFormData($form_data){
        $this->_form_data = $form_data;
        return $this;
    }

 

    /**设置页面模版
     * @param $template 模版
     * @return $this
     */
    public function setTemplate($template){
        $this->_template = $template;
        return $this;
    }

  
	

    //显示页面
    public function display(){
        //编译表单值
        if($this->_form_data){
            foreach($this->_form_items as &$item){
                if($this->_form_data[$item['name']]){
                    $item['value'] = $this->_form_data[$item['name']];
                }
            }
        }
		
		$this->assign('echarts_category', str_replace("'_T3T2_',","",$this->_echarts_category));
		$this->assign('echarts_legend', str_replace("'_T3T2_',","",$this->_echarts_legend));
		$this->assign('echarts_field', $this->_echarts_field);
		$this->assign('echarts_title', $this->_echarts_title);
        $this->assign('title', $this->_title);
        $this->assign('url', $this->_url);
        $this->assign('form_items', $this->_form_items);
        parent::display($this->_template);
    }
}
