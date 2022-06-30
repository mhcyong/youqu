<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 主题自动根据设备切换
 * 
 * @package SwitchTheme 
 * @author loftor
 * @version 1.0.0
 * @link http://loftor.com
 */
 
 require_once 'Mobile_Detect.php';

class ThemeSwitcher_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('index.php')->begin = array('ThemeSwitcher_Plugin', 'switchTheme');
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        Typecho_Widget::widget('Widget_Options')->to($options); 
        Typecho_Widget::widget('Widget_Themes_List')->to($themes);
        $availableThemes = array();
        while($themes->next()){
            $availableThemes[$themes->name]=$themes->title;
        }


        $moblie =  new Typecho_Widget_Helper_Form_Element_Select(
          'moblie', $availableThemes, $options->theme,
          '手机主题', '手机上看到的主题');
        $form->addInput($moblie);

         $tablet =  new Typecho_Widget_Helper_Form_Element_Select(
          'tablet', $availableThemes, $options->theme,
          '平板主题', '平板上看到的主题');
        $form->addInput($tablet);

        $other =  new Typecho_Widget_Helper_Form_Element_Select(
          'other', $availableThemes, $options->theme,
          '默认主题', '除了上面的设备看到的主题');
        $form->addInput($other);
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
    /**
     * 切换主题
     * 
     * @access public
     * @return void
     */
    public static function switchTheme()
    {
        $detect = new Mobile_Detect;
        Typecho_Widget::widget('Widget_Options')->to($options); 
        $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
        if ($deviceType=='phone') {
            $options->theme=$options->plugin('ThemeSwitcher')->moblie;
            return;
        }

         if ($deviceType=='tablet') {
            $options->theme=$options->plugin('ThemeSwitcher')->tablet;
            return;
        }

         if ($deviceType=='computer') {
            $options->theme=$options->plugin('ThemeSwitcher')->other;
            return;
        }
    }


}
