<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
	<?php
		
		print_r($_REQUEST);
		
		if(!empty($_GET['r'])) {
			$subreddit = $_GET['r'];
		}
		
		if(!empty($_REQUEST['r'])) {
			$subreddit = $_REQUEST['r'];
		}
	?>
		<title>reddit top 10 - r/
			<?php
				if(isset($subreddit)) {
					print($subreddit);
				} else {
					print('all');
				}
			?>
		</title>
	</head>
	<body>
	<form action="http://e-wit.co.uk/israel/reddit/" method="post">
	    <div>
	        <label>r/</label>
	        <input name="r" type="text">
	        <input name="name" type="text">
	        <button>Give me reddits!</button>
	    </div>
	</form>
<?php
	if(!isset($subreddit)) {
		if(get_http_response_code('http://www.reddit.com/hot.json?limit=10') != "404" || get_http_response_code('http://www.reddit.com/hot.json?limit=10') != "403"){
    		$output = object_to_array(json_decode(file_get_contents('http://www.reddit.com/hot.json?limit=10')));
    		$output = $output['data']['children'];
		}
	} else {
		if(get_http_response_code('http://www.reddit.com/r/'.$subreddit.'/hot.json?limit=10') != "404" || get_http_response_code('http://www.reddit.com/r/'.$subreddit.'/hot.json?limit=10') != "403"){
    		$output = object_to_array(json_decode(file_get_contents('http://www.reddit.com/r/'.$subreddit.'/hot.json?limit=10')));
    		$output = $output['data']['children'];
		}
	}
	
	if(isset($output)) {
		$count = 1;
		foreach ($output AS $post) {
			print($count.'. ');
			?>
			<a href="http://reddit.com<?php print($post['data']['permalink']); ?>"><?php print($post['data']['title']); ?></a>
			<?php
				if($post['data']['domain'] == 'i.imgur.com') {
					?>
					<img src="<?php print($post['data']['url']); ?>" width="300" height="300"/>
					<?php
				} else if($post['data']['domain'] == 'imgur.com') {
					$img = substr($post['data']['url'], 17, strlen($post['data']['url']) + 1);
					?>
					<img src="<?php print('http://i.imgur.com/'.$img.'.jpg'); ?>" width="300" height="300"/>
					<?php
				}
			?>
			<br /><br />
			<?php
			$count++;
		}
	} else {
		?>
		<h1><?php print('subreddit does not exist, try another'); ?></h1>
		<?php
	}
	
	function object_to_array($data)
	{
	    if (is_array($data) || is_object($data))
	    {
	        $result = array();
	        foreach ($data as $key => $value)
	        {
	            $result[$key] = object_to_array($value);
	        }
	        return $result;
	    }
	    return $data;
	}
	
	function get_http_response_code($url) {
	    $headers = get_headers($url);
	    
	    return substr($headers[0], 9, 3);
	}
?>
	</body>
</html>