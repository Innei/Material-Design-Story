<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");

function themeConfig($form) {

	$style_BG = new Typecho_Widget_Helper_Form_Element_Text('style_BG', NULL, NULL, _t('背景图设置'), _t('填入图片 URL 地址，留空为关闭, 一般为http://www.yourblog.com/image.png,支持 https:// 或 //'));
	$form->addInput($style_BG->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));

	$shortcut_ico = new Typecho_Widget_Helper_Form_Element_Text('shortcut_ico', NULL, NULL, _t('favicon设置'), _t('填写网站图标地址，留空为关闭, 一般为http://www.yourblog.com/image.png,支持 https:// 或 //'));
	$form->addInput($shortcut_ico->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));

	$NAME = new Typecho_Widget_Helper_Form_Element_Text('NAME', NULL, 'INNEI', _t('网页标题设置'), _t('仅支持5个字符, 多了会省略, 少了会空白, 默认为INNEI, 请参考原主题修改大于5个字符'));
	$form->addInput($NAME);

	$isRSS = new Typecho_Widget_Helper_Form_Element_Radio('isRSS', 
		array('on' => _t('显示'),
			'off' => _t('隐藏')),
		'off', _t('显示RSS'),_t('在菜单栏中加入 RSS 按钮'));
	$form->addInput($isRSS);  

	$isAutoNav = new Typecho_Widget_Helper_Form_Element_Radio('isAutoNav',
		array('on' => _t('开启'),
			'off' => _t('关闭')),
		'on', _t('自动调整'),_t('自动设置导航栏中 margin 及 width 值（推荐开启）'));
	$form->addInput($isAutoNav);

	$isIconNav = new Typecho_Widget_Helper_Form_Element_Radio('isIconNav',
		array('on' => _t('开启'),
			'off' => _t('关闭')),
		'off', _t('替换表情'),_t('将导航栏中的 1,2,3 替换成 Emoji 图标'));
	$form->addInput($isIconNav);

	$runtime = new Typecho_Widget_Helper_Form_Element_Radio('runtime',
		array('PHP' => _t('PHP显示'),
			'JS' => _t('JS显示'),
			'NONE' => _t('不显示'),
		),
		'JS', _t('网站显示运行时间设置'), _t('PHP为显示服务器运行时间,JS为自定义时间'));
	$form->addInput($runtime);

	$hitokoto = new Typecho_Widget_Helper_Form_Element_Radio('hitokoto',
		array('on' => _t('显示'),
			'off' => _t('不显示'),
		),
		'on', _t('显示一言'), _t('在标题栏下方显示一言'));
	$form->addInput($hitokoto);
	
	$showDec = new Typecho_Widget_Helper_Form_Element_Radio('showDec', 
		array('on' => _t('显示'),
			'off' => _t('隐藏')),
		'off', _t('显示文章概要'),_t('鼠标悬停标题框出现概要'));
	$form->addInput($showDec);  
	
	$copyright = new Typecho_Widget_Helper_Form_Element_Radio('copyright',
		array('on' => _t('显示'),
			'off' => _t('不显示'),
		),
		'on', _t('显示版权信息'), _t('在文章下方显示版权信息'));
	$form->addInput($copyright);

	$modifiedDate = new Typecho_Widget_Helper_Form_Element_Radio('modifiedDate',
		array('on' => _t('显示'),
			'off' => _t('不显示'),
		),
		'on', _t('显示长时间未修改的读者通知'), _t('如超过30天未修改在文章标题下方显示长时间未修改通知'));
	$form->addInput($modifiedDate);

	$showCommentNum = new Typecho_Widget_Helper_Form_Element_Radio('showCommentNum',
		array('on' => _t('显示'),
			'off' => _t('不显示'),
		),
		'on', _t('显示评论数'), _t(''));
	$form->addInput($showCommentNum);
}

function parseContnet($content){ //解析文章 暂只是添加h3,h4锚点,为 <img> 添加 data-action
    //添加导航树
	$torHTML=post_tor($content);
	if($torHTML!=''){
		$content='<div id="torTree"><h4>导航树</h4>'.$torHTML.'</div>'.$content;
	}

    //添加h3,h4锚点
	$ftitle=array();
	preg_match_all('/<h([3-4])>(.*?)<\/h[3-4]>/', $content, $title);
	$num=count($title[0]);

	for ($i=0; $i < $num; $i++) { 
		$f=$title[2][$i];
		$type=$title[1][$i];
		if ($type=='3') {
			$ff='<h3 id="anchor-'.$i.'">'.$f.'</h3>';
		}
		if ($type=='4') {
			$ff='<h4 id="anchor-'.$i.'">'.$f.'</h4>';
		}
		array_push($ftitle, $ff);
	}
	for ($i=0; $i < $num; $i++) { 
		$content=str_replace_limit($title[0][$i],$ftitle[$i],$content);
	}

    //<img> 添加 data-action
	$fimg=array();
	preg_match_all('/<img (.*?)>/', $content, $img);
	$num=count($img[0]);

	for ($i=0; $i < $num; $i++) { 
		$f=$img[1][$i];
		$ff='<img data-action="zoom" '.$f.'>';

		array_push($fimg, $ff);
	}
	for ($i=0; $i < $num; $i++) { 
		$content=str_replace_limit($img[0][$i],$fimg[$i],$content);
	}

	print_r($content);
}
function str_replace_limit($search,$replace,$subject,$limit=1) {
	if (is_array($search)) {
		foreach ($search as $k=>$v) {
			$search[$k]='`'.preg_quote($search[$k],'`').'`';
		}
	} else {
		$search='`'.preg_quote($search,'`').'`';
	}

	return preg_replace($search,$replace,$subject,$limit);
}
function post_tor($content){
	$tor=array();
	$f='';
	preg_match_all('/<h[3-4]>(.*?)<\/h[3-4]>/', $content, $tor_i);
	$num=count($tor_i[0]);
	for ($i=0; $i < $num; $i++) { 
		$n=$i+1;
		$a='<a href="#anchor-'.$n.'">'.$tor_i[0][$i].'</a>';
		$f=$f.$a;
	}
	$f=str_replace('<h3>','<span class="tori">',$f);
	$f=str_replace('</h3>','</span><br>',$f);
	$f=str_replace('<h4>','<span class="torii">',$f);
	$f=str_replace('</h4>','</span><br>',$f);
	if ($num==0) {
		return '';
	} else {
		return $f;
	}
}
function get_post_view($archive)
{
	$cid    = $archive->cid;
	$db     = Typecho_Db::get();
	$prefix = $db->getPrefix();
	if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
		$db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
		echo 0;
		return;
	}
	$row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
	if ($archive->is('single')) {
		$views = Typecho_Cookie::get('extend_contents_views');
		if(empty($views)){
			$views = array();
		}else{
			$views = explode(',', $views);
		}
		if(!in_array($cid,$views)){
			$db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
			array_push($views, $cid);
			$views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
        }
    }
    echo $row['views'];
}
?>
