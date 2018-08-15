<?php

use Resource\Collection\ArrayList;

/**
 * The AdminSidebar Class, defines a unique Admin Control Panel Sidebar.
 * It extends from the Sidebar class, although it does not really have much to do with the parent class.
 * @category Resource
 * @package Widget
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class AdminSidebar extends Widget implements Initializable{

	/**
     * Constructor of AdminSidebar Class, it initializes basic sidebar properties     
     * @access public
     * @return Void
     */
    public function __construct(){
	    $this->initialize();		
    }
	
	/**
     * The setDivisions method, setter method for property $division.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
	 * @param ArrayList $components
     * @access protected
     * @return Void
     */
    protected function setDivisions($components){
		$this->division = new Division($components);
		$this->division->setClass("sidebar");
    }

	/**
     * The initialize method, sets up the entire admin sidebar.
     * @access public
     * @return Void
     */		
	public function initialize(){
	    $components = new ArrayList;
		$components->add(new Division(new Link("admincp", "Dashboard")));
		
		$components->add(new Division(new Comment("Adoptable", FALSE)));
		$adoptable = new Division;
		$adoptable->add(new Link("admincp/adopt/add", "Create New Adoptables"));
		$adoptable->add(new Link("admincp/adopt/edit", "Edit Existing Adoptables"));
		$components->add($adoptable);
		
		$components->add(new Division(new Comment("Adopt Levels", FALSE)));
		$level = new Division;
		$level->add(new Link("admincp/level/add", "Add Levels"));
		$level->add(new Link("admincp/level/edit", "Edit Levels"));
		$level->add(new Link("admincp/level/delete", "Delete Levels"));
		$level->add(new Link("admincp/level/settings", "Level Settings"));
		$level->add(new Link("admincp/level/daycare", "Daycare Settings"));		
		$components->add($level);
		
		$components->add(new Division(new Comment("Owned Adoptables", FALSE)));
		$ownedAdoptable = new Division;
		$ownedAdoptable->add(new Link("admincp/ownedadopt/add", "Give Adopt to User"));
		$ownedAdoptable->add(new Link("admincp/ownedadopt/edit", "Manage Users Adopts"));
		$ownedAdoptable->add(new Link("admincp/ownedadopt/delete", "Delete Users Adopts"));
		$components->add($ownedAdoptable);
		
		$components->add(new Division(new Comment("Breeding", FALSE)));
		$breeding = new Division;
		$breeding->add(new Link("admincp/breeding/add", "Create new Breed Adopt"));
		$breeding->add(new Link("admincp/breeding/edit", "Update Existing Breed Adopt"));
		$breeding->add(new Link("admincp/breeding/delete", "Delete Breed Adopt"));
		$breeding->add(new Link("admincp/breeding/settings", "Change Breeding Settings"));
		$components->add($breeding);
		
		$components->add(new Division(new Comment("Images", FALSE)));
		$image = new Division;
		$image->add(new Link("admincp/image/upload", "Upload Images"));
		$image->add(new Link("admincp/image/delete", "Erase Images"));
		$image->add(new Link("admincp/image/settings", "Adoptable Signature Image/GD Settings"));
		$components->add($image);
		
		$components->add(new Division(new Comment("Users", FALSE)));
		$users = new Division;
		$users->add(new Link("admincp/user/edit", "Manage Users"));
		$users->add(new Link("admincp/user/delete", "Delete Users"));
		$components->add($users);
		
		$components->add(new Division(new Comment("Usergroups", FALSE)));
		$usergroups = new Division;
		$usergroups->add(new Link("admincp/usergroup/add", "Add Usergroup"));
		$usergroups->add(new Link("admincp/usergroup/edit", "Edit Usergroup"));
		$usergroups->add(new Link("admincp/usergroup/delete", "Delete Usergroup"));
		$components->add($usergroups);
		
		$components->add(new Division(new Comment("Items", FALSE)));
		$items = new Division;
		$items->add(new Link("admincp/item/add", "Create an Item"));
		$items->add(new Link("admincp/item/edit", "Manage Items"));
		$items->add(new Link("admincp/item/delete", "Delete Items"));
		$items->add(new Link("admincp/item/functions", "Browse Item Functions"));
		$components->add($items);
		
		$components->add(new Division(new Comment("Inventory", FALSE)));
		$inventory = new Division;
		$inventory->add(new Link("admincp/inventory/add", "Give Item to User"));
		$inventory->add(new Link("admincp/inventory/edit", "Edit User Inventory"));
		$inventory->add(new Link("admincp/inventory/delete", "Delete Users items"));
		$components->add($inventory);
		
		$components->add(new Division(new Comment("Shops", FALSE)));
		$shops = new Division;
		$shops->add(new Link("admincp/shop/add", "Add a Shop"));
		$shops->add(new Link("admincp/shop/edit", "Edit Shops"));
		$shops->add(new Link("admincp/shop/delete", "Delete Shops"));
		$components->add($shops);
		
		$components->add(new Division(new Comment("Trade", FALSE)));
		$shops = new Division;
		$shops->add(new Link("admincp/trade/add", "Create a Trade"));
		$shops->add(new Link("admincp/trade/edit", "Update Trades"));
		$shops->add(new Link("admincp/trade/delete", "Remove Trades"));
		$shops->add(new Link("admincp/trade/moderate", "Moderate Trades"));
		$shops->add(new Link("admincp/trade/settings", "Change Trade Settings"));		
		$components->add($shops);		
		
		$components->add(new Division(new Comment("Content", FALSE)));
		$content = new Division;
		$content->add(new Link("admincp/content/add", "Add a Custom Page"));
		$content->add(new Link("admincp/content/edit", "Edit Custom Pages"));
		$content->add(new Link("admincp/content/delete", "Delete Custom Pages"));
		$components->add($content);

		$components->add(new Division(new Comment("Module", FALSE)));
		$module = new Division;
		$module->add(new Link("admincp/module/add", "Create new Module"));
		$module->add(new Link("admincp/module/edit", "Edit Modules"));
		$module->add(new Link("admincp/module/delete", "Delete Modules"));
		$components->add($module);

		$components->add(new Division(new Comment("Widget", FALSE)));
		$widget = new Division;
		$widget->add(new Link("admincp/widget/add", "Create new Widget"));
		$widget->add(new Link("admincp/widget/edit", "Edit Widgets"));
		$widget->add(new Link("admincp/widget/delete", "Delete Widgets"));
		$components->add($widget);
		
		$components->add(new Division(new Comment("Links", FALSE)));
		$links = new Division;
		$links->add(new Link("admincp/links/add", "Add a link"));
		$links->add(new Link("admincp/links/edit", "Edit a link"));
		$links->add(new Link("admincp/links/delete", "Delete a Link"));
		$components->add($links);
		
		$components->add(new Division(new Comment("Promocodes", FALSE)));
		$promo = new Division;
		$promo->add(new Link("admincp/promo/add", "Create New Promocode"));
		$promo->add(new Link("admincp/promo/edit", "Edit Promocodes"));
		$promo->add(new Link("admincp/promo/delete", "Delete Promocodes"));
		$components->add($promo);
	
		$components->add(new Division(new Comment("Themes", FALSE)));
		$theme = new Division;
		$theme->add(new Link("admincp/theme/add", "Add/Install New Theme"));
		$theme->add(new Link("admincp/theme/edit", "Update Themes"));
		$theme->add(new Link("admincp/theme/delete", "Delete Themes"));
		$theme->add(new Link("admincp/theme/css", "Additional CSS"));
		$components->add($theme);
	
		$components->add(new Division(new Comment("Settings", FALSE)));
		$settings = new Division;
		$settings->add(new Link("admincp/settings/globals", "Basic Settings"));
		$settings->add(new Link("admincp/settings/pound", "Pound Settings"));
		$settings->add(new Link("admincp/settings/plugin", "View Plugins"));
		$components->add($settings);
		
		$components->add(new Division(new Comment("Advertising", FALSE)));
		$ads = new Division;
		$ads->add(new Link("admincp/ads/add", "Create New Ad"));
		$ads->add(new Link("admincp/ads/edit", "Edit Current Campaigns"));
		$ads->add(new Link("admincp/ads/delete", "Delete Existing Campaigns"));
		$components->add($ads);
		$this->setDivisions($this->addClass($components));
	}

	/**
     * The addClass method, loops through the components array and add classes for each component.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
	 * @param ArrayList  $components
     * @access protected
     * @return ArrayList
     */	
	protected function addClass(ArrayList $components){
	    $components->get(0)->setClass("accordionButton");
		for($i = 1; $i < $components->size(); $i += 2){
		    $components->get($i)->setClass("accordionButton"); 
            $components->get($i + 1)->setClass("accordionContent");			
		}
		return $components;
	}
}
?>
