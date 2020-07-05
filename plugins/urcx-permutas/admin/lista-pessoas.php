<?php

require_once(dirname(__FILE__).'/../core/admin-page-view.php');

class Urcx_Permutas_Lista_Pessoas implements iAdminPageView{

  private static $instance;

  public static function getInstance() {
    if (self::$instance == NULL) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function registerMenu(){
    add_submenu_page(
      'banco_permutas',
      'Banco de Permutas - Lista de Pessoas',
      'Lista Pessoas',
      'manage_options',
      'banco_permutas_lista',
      array($this, 'render'),
      2

    );
  }
  public function render(){
    echo <<<EOF
    <div class="wrap">
      <h1>Banco de permuta</h1>
      <h3>Lista de pessoas cadastradas</h3>

      <form method="get">
  	  	<p class="search-box">
	        <label class="screen-reader-text" for="user-search-input">Search Users:</label>
	        <input type="search" id="user-search-input" name="s" value="">
          <input type="submit" id="search-submit" class="button" value="Search Users">
        </p>
        <input type="hidden" id="_wpnonce" name="_wpnonce" value="cc717443ad">
        <input type="hidden" name="_wp_http_referer" value="/wp-admin/users.php">
        <div class="tablenav top">
        	<div class="alignleft actions bulkactions">
            <label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label>
            <select name="action" id="bulk-action-selector-top">
              <option value="-1">Ações</option>
	            <option value="delete">Apagar</option>
            </select>
            <input type="submit" id="doaction" class="button action" value="Apply">
		      </div>
		  		<div class="alignleft actions">
		  		  <label class="screen-reader-text" for="new_role">Todos os orgãos</label>
		        <select name="new_role" id="new_role">
		  	      <option value="">Todos os orgãos</option>

            </select>
            <input type="submit" name="changeit" id="changeit" class="button" value="Change">
          </div>
          <div class="tablenav-pages one-page">
            <span class="displaying-num">1 item</span>
            <span class="pagination-links"><span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>
            <span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
            <span class="paging-input">
              <label for="current-page-selector" class="screen-reader-text">Current Page</label>
              <input class="current-page" id="current-page-selector" type="text" name="paged" value="1" size="1" aria-describedby="table-paging">
              <span class="tablenav-paging-text"> of <span class="total-pages">1</span></span>
            </span>
            <span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>
            <span class="tablenav-pages-navspan button disabled" aria-hidden="true">»</span>
            </span>
          </div>
		      <br class="clear">
	      </div>
        <h2 class="screen-reader-text">Users list</h2>
        <table class="wp-list-table widefat fixed striped users">
	        <thead>
	          <tr>
              <td id="cb" class="manage-column column-cb check-column">
                <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                <input id="cb-select-all-1" type="checkbox">
              </td>
              <th scope="col" id="username" class="manage-column column-username column-primary sortable desc">
                <a href="http://localhost:8080/wp-admin/users.php?orderby=login&amp;order=asc">
                  <span>Username</span>
                  <span class="sorting-indicator"></span>
                </a>
              </th>
              <th scope="col" id="name" class="manage-column column-name">Name</th>
              <th scope="col" id="email" class="manage-column column-email sortable desc">
                <a href="http://localhost:8080/wp-admin/users.php?orderby=email&amp;order=asc">
                  <span>Email</span>
                  <span class="sorting-indicator"></span>
                </a>
              </th>
              <th scope="col" id="role" class="manage-column column-role">Role</th>
              <th scope="col" id="posts" class="manage-column column-posts num">Posts</th>
            </tr>
	        </thead>
          <tbody id="the-list" data-wp-lists="list:user">
            <tr id="user-1">
              <th scope="row" class="check-column">
                <label class="screen-reader-text" for="user_1">Select administrator</label>
                <input type="checkbox" name="users[]" id="user_1" class="administrator" value="1">
              </th>
              <td class="username column-username has-row-actions column-primary" data-colname="Username">
                <strong><a href="#">administrator</a></strong>
                <br>
                <div class="row-actions">
                  <span class="edit">
                    <a href="#">Edit</a> |
                  </span>
                  <span class="view">
                    <a href="#" aria-label="View posts by administrator">View</a>
                  </span>
                </div>
                <button type="button" class="toggle-row">
                  <span class="screen-reader-text">Show more details</span>
                </button>
              </td>
              <td class="name column-name" data-colname="Name">
                <span aria-hidden="true">—</span>
                <span class="screen-reader-text">Unknown</span>
              </td>
              <td class="email column-email" data-colname="Email">
                <a href="#">fexdelux@gmail.com</a>
              </td>
              <td class="role column-role" data-colname="Role">Administrator</td>
              <td class="posts column-posts num" data-colname="Posts">
                <a href="#" class="edit">
                  <span aria-hidden="true">1</span>
                  <span class="screen-reader-text">1 post by this author</span>
                </a>
              </td>
            </tr>
          </tbody>
          <tfoot>
	          <tr>
              <td class="manage-column column-cb check-column">
                <label class="screen-reader-text" for="cb-select-all-2">Select All</label>
                <input id="cb-select-all-2" type="checkbox">
              </td>
              <th scope="col" class="manage-column column-username column-primary sortable desc">
                <a href="#">
                  <span>Username</span>
                  <span class="sorting-indicator"></span>
                </a>
              </th>
              <th scope="col" class="manage-column column-name">Name</th>
              <th scope="col" class="manage-column column-email sortable desc">
                <a href="#">
                  <span>Email</span>
                  <span class="sorting-indicator"></span>
                </a>
              </th>
              <th scope="col" class="manage-column column-role">Role</th>
              <th scope="col" class="manage-column column-posts num">Posts</th>
            </tr>
	        </tfoot>
        </table>

		  </form>
    </div>
EOF;
  }


}
