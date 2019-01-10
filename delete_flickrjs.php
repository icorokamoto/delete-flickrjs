<?php
/*
Plugin Name: Delete Flickr Javascript
Plugin URI: http://www.icoro.com/
Description: Delete! Delete! Delete!
Version: 1.0
Author: OKAMOTO Yutaka
*/

/*
 投稿時にflickrの不要なjavascriptとそれに付随するものを記事中から除去します。具体的には

 <a data-flickr-embed="true"  href="https://www.flickr.com/photos/35962451@N04/32214392978/in/album-72157702599309461/" title="ポテトデラックス"><img src="https://farm5.staticflickr.com/4894/32214392978_e918a77c87.jpg" width="500" height="333" alt="ポテトデラックス"></a><script async src="//embedr.flickr.com/assets/client-code.js" charset="utf-8"></script>

これ↑ を こう↓ します。

<a href="https://www.flickr.com/photos/35962451@N04/32214392978/in/album-72157702599309461/" title="ポテトデラックス"><img src="https://farm5.staticflickr.com/4894/32214392978_e918a77c87.jpg" width="500" height="333" alt="ポテトデラックス"></a>
*/
function delete_fuckin_flickr_javascript($data, $postarr) {

  $content = $data['post_content'];

  // クォートがエスケープされた状態になっているので、「"」を検索するには「\\\"」にしないとだめっぽい。
  $pattern = '/<figure>[\s]*?<a data-flickr-embed=\\\"true\\\"[ ]+([\s\S]+?)<script async src=\\\"\/\/embedr\.flickr\.com\/assets\/client-code\.js\\\" charset=\\\"utf-8\\\"><\/script>([\s\S]*?)<\/figure>/';

  $replace = '<figure><a $1$2</figure>';

  $data['post_content'] = preg_replace($pattern, $replace, $content);

  return $data;
}

add_filter('wp_insert_post_data', 'delete_fuckin_flickr_javascript', '99', 2);
?>
