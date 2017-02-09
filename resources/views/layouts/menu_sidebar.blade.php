<aside class="col-sm-3 col-md-2 sidebar">
	<div class="top-navigation">
		<div class="t-menu">MENU</div>
		<div class="t-img">
			<img src="{{ Request::root()}}/images/lines.png" alt="" />
		</div>
		<div class="clearfix"> </div>
	</div>
	<div class="drop-navigation drop-navigation">
		<ul class="nav nav-sidebar">
			<li class="active">
				<a href="{{ route('home') }}" class="home-icon">
					<span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home
				</a>
			</li>
			<li>
                <a href="{{ route('authors') }}" class="user-icon">
					<i class="fa fa-users fa-lg" aria-hidden="true"></i>Authors
                </a>
            </li>
			<li>
				<a href="{{ route('books') }}" class="sub-icon">
					<i class="fa fa-book fa-lg"></i>Books
				</a>
			</li>
			<li>
				<a href="{{ route('categories') }}" class="sub-icon">
					<i class="fa fa-book fa-lg"></i>Categories
				</a>
			</li>
			<li>
				<a href="{{ route('author-add-get') }}" class="sub-icon">
					<i class="fa fa-book fa-lg"></i>Add author
				</a>
			</li>
			<li><a href="movies.html" class="song-icon"><span class="glyphicon glyphicon-music" aria-hidden="true"></span>Songs</a></li>
			<li><a href="news.html" class="news-icon"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>News</a></li>
		</ul>
		<div class="side-bottom">
				<div class="side-bottom-icons">
					<ul class="nav2">
						<li><a href="#" class="facebook"> </a></li>
						<li><a href="#" class="facebook twitter"> </a></li>
						<li><a href="#" class="facebook chrome"> </a></li>
						<li><a href="#" class="facebook dribbble"> </a></li>
					</ul>
				</div>
				<div class="copyright">
					<p>Copyright © 2015 My Play. All Rights Reserved | Design by <a href="http://w3layouts.com/">W3layouts</a></p>
				</div>
		</div>
	</div>
</aside>