<?php
/**
 * UController.php
 * @author        lu yan hua <838777565@qq.com>
 * @copyright     Copyright (c) 2014-2020 sparui. All rights reserved.
 * @link          http://www.sparui.com
 * @license       http://www.sparui.com/license
 */

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class UController extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '/layouts/main';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu=array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs=array();

    /**
     * 布局区块
     * @var array
     * @author   lu yan hua <838777565@qq.com>
     */
    public $block = array();
}