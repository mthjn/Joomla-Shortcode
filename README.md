### Joomla-Shortcode Plugin
###### Parse all content for shortcodes. Written for Joomla 3.4
  
Plugin to implement shortcodes into Joomla where unlike in Wordpress there is no Shortcode API.  
  
The plugin parses shortcodes in all Joomla content looking for matching RegEx.  
It explodes the string saving parts of it into variables.  
   
There is [branch](https://github.com/mthjn/Joomla-Shortcode/tree/JoomlaShortcode-0.1) with older version. Code presumably even more of a pigsty, but more field tested. [Install zip available.](https://github.com/mthjn/Joomla-Shortcode/tree/JoomlaShortcode-0.1/shortcode-0.1)   
  
#### Modify it  
  
Your own shortcode   
  
  
     //add yours
     $this->doParseIframe( $article );
  
 
[onContentPrepare, ref line 21](https://github.com/mthjn/Joomla-Shortcode/blob/master/shortcode-0.3/shortcode.php)  
  
Your CSS into header  
  
    //change or add link to your file
     $this->getStyles();
  
  
[onBeforeCompileHead, ref on line 17](https://github.com/mthjn/Joomla-Shortcode/blob/master/shortcode-0.3/shortcode.php)    
  
![Short0.2](http://i.giphy.com/xTiTnha7sQBSXcl4SA.gif)

#### Perks
  
###### > Current state of shortcodes
  
The shorts implemented in version 0.3 mimick the portfolio CMS plugins without having to deal with all the backend stuff and only get the nice pictures.  
  
*Functions*  
- Show image with hover overlay with VIEW link leading to another page
- Show image with hover overlay with VIEW and ZOOM button links leading to new page and to magnified prettyphotoed lightboxed bg image, respectively.
- Show image with hover overlay with ZOOM button link to magnified prettyphotoed lightboxed bg image
- Show image with hover overlay with ZOOM button link to a text field -- an iframed Joomla page with no header and footer

###### > Default Usage
  
      {bild url=/some/location/of/a/page}{img=/some/location/of/an/image.jpg}{tt=Title}

Paste into Articles. Will be rendered in the frontend -  the output is an image with Title and button overlay on hover mimicking [SP Simple Portfolio images](http://demo.joomshaper.com/extensions/sp-simple-portfolio) (when you only want the images not the content system around it, it's for you).  
  
  
###### > Joomla Custom HTML module  
  
Will work in Custom HTML module once you have ticked YES on tab "Options" for *Prepare Content*.  
You can insert this as a module into pages via (SP Page Builder)[http://www.joomshaper.com/page-builder] or similar extension - very user friendly  

###### > Link to iframe  
  
Links to an iframe within Joomla installations: Page with no nice menu link can be set as URL in the shortcode, the shortcode type {iframe} will append a string query that will spit the page in a print-ready mode which will remove the header and footer. The iframe content can be a SP Page Builder page - editable by a non-techie person.  
  

