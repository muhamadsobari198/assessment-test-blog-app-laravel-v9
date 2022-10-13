<nav class="sidebar">
	<div class="sidebar-header">
	<a class="sidebar-brand" style="color:#606060; font-size: 22px;font-weight:bold !important">
		Test <span style="color:#2A8FCC;">goKampus</span>
	</a>
	</div>
	<div class="sidebar-body">
		<ul class="nav">

			<li class="nav-item nav-category">Master Data</li>
			@if(_checkSidebar('admin/users'))
				<li id="articles_nav_menu" class="nav-item @if(count(Request::segments()) > 0 && Request::segments()[1] == 'users') active @endif">
					<a href="{{route('users')}}" class="nav-link">
						<i class="fa-solid fa-user"></i>
						<span class="link-title">Users</span>
					</a>
				</li>
			@endif

			@if(_checkSidebar('admin/articles'))
				<li id="articles_nav_menu" class="nav-item @if(count(Request::segments()) > 0 && Request::segments()[1] == 'articles') active @endif">
					<a href="{{route('articles')}}" class="nav-link">
						<i class="fa-solid fa-book"></i>
						<span class="link-title">Article</span>
					</a>
				</li>
			@endif

		</ul>
	</div>
</nav>