(function(){tinymce.PluginManager.requireLangPack('ezfilemanager');tinymce.create('tinymce.plugins.EzfilemanagerPlugin',{init:function(ed,url){ed.addCommand('mceEzfilemanager',function(){ed.windowManager.open({file:url+'/ezfilemanager.php',width:720,height:440,inline:1},{plugin_url:url,some_custom_arg:'custom arg'});});ed.addButton('ezfilemanager',{title:'ezFilemanager',cmd:'mceEzfilemanager',image:url+'/img/ezfilemanager.gif'});ed.onNodeChange.add(function(ed,cm,n){cm.setActive('ezfilemanager',n.nodeName=='IMG');});},createControl:function(n,cm){return null;},getInfo:function(){return{longname:'ezFilemanager plugin',author:'Webnaz Creations Naz',authorurl:'http://www.webnaz.net',infourl:'http://www.webnaz.net',version:"0.5"};}});tinymce.PluginManager.add('ezfilemanager',tinymce.plugins.EzfilemanagerPlugin);})();