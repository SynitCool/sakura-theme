<?php

namespace Elementor;

class Profile_Database extends Widget_Base {
    public function get_name() {
		return 'Profile Database';
	}
	
	public function get_title() {
		return 'Profile Database';
	}
	
	public function get_icon() {
		return 'eicon-person';
	}
	
	public function get_categories() {
		return [ 'sakura-theme-widgets' ];
	}

    protected function _register_controls() {
		
	}

    protected function render() {
        ?> 
            <div class="container">
				<div class="d-flex flex-column text-center">
					<div class="p-2">
						<img class="rounded-circle" alt="avatar1" width="150" height="150" src="https://cdn-icons-png.flaticon.com/512/168/168724.png" />
					</div>
					<div class="p-2">
						<h1>Jhon Hooke</h1>
						<p>An Awesome guy that loves about universe and space or computer</p>
					</div>
					<div class="p-2">
						<div class="row">
							<div class="col">
								<p>Category 1</p>
							</div>
							<div class="col">
								<p>Category 2</p>
							</div>
							<div class="col">
								<p>Category 3</p>
							</div>
						</div>
					</div>
					<br/>
					<div class="p-2">
						<div class="col">
							<div class="row">
								<div class="col">
									<img class="rounded" alt="avatar1" src="https://cdn-icons-png.flaticon.com/512/168/168734.png" />
								</div>
								<div class="col">
									<img class="rounded" alt="avatar1" src="https://cdn-icons-png.flaticon.com/512/168/168734.png" />
								</div>
								<div class="col">
									<img class="rounded" alt="avatar1" src="https://cdn-icons-png.flaticon.com/512/168/168734.png" />
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col">
									<img class="rounded" alt="avatar1" src="https://cdn-icons-png.flaticon.com/512/168/168734.png" />
								</div>
								<div class="col">
									<img class="rounded" alt="avatar1" src="https://cdn-icons-png.flaticon.com/512/168/168734.png" />
								</div>
								<div class="col">
									<img class="rounded" alt="avatar1" src="https://cdn-icons-png.flaticon.com/512/168/168734.png" />
								</div>
							</div>
						<div>
					</div>
				</div>
			</div>
        <?php
    }

    protected function _content_template() {

    }
}