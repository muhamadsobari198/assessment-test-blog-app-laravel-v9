<nav class="navbar">
	<a href="#" class="sidebar-toggler">
		<i data-feather="menu"></i>
	</a>
	<div class="navbar-content">

		<ul class="navbar-nav">
			<li class="nav-item dropdown nav-profile">
				<a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" draggable="false">
					<b>{{ Session::get('user')->name }}</b>&nbsp;
					<img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" style="object-fit:cover;" draggable="false">
				</a>
				<div class="dropdown-menu" aria-labelledby="profileDropdown">
					<div class="dropdown-header d-flex flex-column align-items-center">
						<div class="figure mb-3">
							<img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" style="object-fit:cover;" draggable="false">
						</div>
						<div class="info text-center">
							<p class="name font-weight-bold mb-0">{{ Session::get('user')->name}}</p>
							<p class="email text-muted mb-3">{{ Session::get('user')->email }}</p>
						</div>
					</div>
					<div class="dropdown-body">
						<ul class="profile-nav p-0 pt-3">
							<li class="nav-item">
								<a href="{{ route('logout') }}" class="nav-link">
									<i data-feather="log-out"></i>
									<span>Keluar</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</li>
		</ul>
	</div>
</nav>