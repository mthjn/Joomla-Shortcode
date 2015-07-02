### Joomla-Shortcode Plugin
###### Makes it possible to use shortcodes within Joomla
  
Plugin to implement shortcodes into Joomla where unlike in Wordpress there is no Shortcode API.  
  
The plugin parses shortcodes in all Joomla content looking for matching RegEx.  
It explodes the string saving parts of it into variables.  

#### Perks
  
###### Default Usage

      {bild url=/some/location/of/a/page}{img=/some/location/of/an/image.jpg}{tt=Title}

Paste into Articles. Will be rendered in the frontend -  the output is an image with Title and button overlay on hover mimicking [SP Simple Portfolio images](http://demo.joomshaper.com/extensions/sp-simple-portfolio) (when you only want the images not the content system around it, it's for you).  
  
  
###### Joomla Custom HTML module  

Will work in Custom HTML module once you have ticked YES on tab "Options" for *Prepare Content*.  
You can insert this as a module into pages via (SP Page Builder)[http://www.joomshaper.com/page-builder] or similar extension - very user friendly  

###### Link to iframe  



#### Modify it  

Your own regex condition  
(onContentPrepare, line 45 and lower)[https://github.com/mthjn/Joomla-Shortcode/blob/master/shortcode-0.3/shortcode.php]  

Your CSS into header 
(onBeforeCompileHead, line 23)[https://github.com/mthjn/Joomla-Shortcode/blob/master/shortcode-0.3/shortcode.php]    

(http://i.giphy.com/xTiTnha7sQBSXcl4SA.gif)
