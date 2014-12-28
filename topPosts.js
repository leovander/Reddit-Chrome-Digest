var topPosts, postTitle, totalPoints, downVotes, upVotes, username, permalink, subreddit;
			
$(function() {
	var request = $.ajax({
		url: "http://www.reddit.com/r/all/hot.json?limit=10",
		type: "GET",
		timeout: 30000,
		success:function(data, textStatus) {
			topPosts = data;
		},
		error:function(jqXHR, textStatus, errorThrown) {
			console.log("Error during request "+textStatus+" (http://www.reddit.com/r/all/hot.json?limit=1)");
			console.log(errorThrown);
		}
	}).done(function() {
		$('#topPosts tbody').empty();
		for(var i = 0; i < 10; i++) {
			postTitle = topPosts.data.children[i].data.title;
			if(postTitle.length > 50) {
				postTitle = postTitle.substring(0, 50) + '...';	
			} else {
				postTitle = postTitle.substring(0, 50);
			}
			permalink = topPosts.data.children[i].data.permalink;
			totalPoints = topPosts.data.children[i].data.ups - topPosts.data.children[i].data.downs;
			subreddit = topPosts.data.children[i].data.subreddit;
			
			$('#topPosts tbody').append('<tr><td>' + (i+1) + '.</td><td><a href="http://reddit.com' + permalink + '" target="_blank">'+ postTitle +'</a></td><td><a href="http://reddit.com/r/' + subreddit + '" target="_blank">r/' + subreddit + '</a></td><td>' + totalPoints + '</td></tr>');
		}
	});
});