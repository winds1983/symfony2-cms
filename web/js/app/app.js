/**
 * Backbone MVC example
 */

$(function(){
	
	var User = Backbone.Model.extend({
		
		initialize: function() {
			//alert('123');
		},
		
		// define default values
		defaults: {
			name: 'Sun Feng',
			age: 29,
			company: 'Shinetech Software Inc.',
		},
		
	});
	
	var UserList = Backbone.Collection.extend({
		model: User
	});
	
	var UserView = Backbone.View.extend({
		//el: $('body'),
		el: $('.container'),
		
		events: {
			'click button#add': 'addItem',
			'click button#addUser': 'addUser',
			'click a.get-user': 'renderUserList',
			'change select.group': 'groupChange',
		},
		
		initialize: function() {
			_.bindAll(this, 'render', 'addItem', 'renderUserList', 'groupChange', 'addUser', 'appendUser');
			
			this.collection = new UserList;
			this.collection.bind('add', this.appendUser);
			
			this.userCounter = 0;
			this.itemCounter = 0;
			
			this.render(); // default to render view
		},
		
		render: function() {
			var user = new User;
			$(this.el).find('.span3').append('<li>Hello, '+user.get('name')+'</li>');
			
			$(this.el).find('.span3').append('<button id="add">Add new item</button>');
			$(this.el).find('.span3').append('<button id="addUser">Add new user</button>');
			$(this.el).find('.span3').append('<div class="count-list"><ul></ul></div>');
			
			var self = this;
			//console.log(this.collection);
			_(this.collection.models).each(function(user){
				self.appendUser(user);
			}, this);
		},
		
		addItem: function() {
			this.itemCounter++;
			$('.count-list ul').append('<li style="font-size: '+this.itemCounter+'px">'+this.itemCounter+' Hello world!</li>');
		},
		
		renderUserList: function() {
			$.ajax({
				url: 'data/ajax.php?action=getUsers',
				type: 'POST',
				dataType: 'json',
				success: function(response) {
					var html = '';
					/*for(var i=0; i < response.length; i++) {
						html += '<li>Name: '+response[i].name+' Age:'+response[i].age+' Company:'+response[i].company+'</li>';
					}*/
					_.each(response, function(user) {
						html += '<li>Name: '+user.name+' Age:'+user.age+' Company:'+user.company+'</li>';
					});
					$('ul.user-list').html(html);
				},
			});
		},
		
		groupChange: function() {
			var groupId = $('.group').val();
			//alert(group);
			
			if (groupId != '') {
				$.ajax({
					url: 'data/ajax.php?action=getSubGroups',
					type: 'GET',
					data: '&groupId='+groupId,
					dataType: 'json',
					success: function(response) {
						$('.sub-group').html('');
						var html = '';
						/*for(var i=0; i < response.length; i++) {
							html += '<option value="'+response[i].id+'">'+response[i].name+'</option>';
						}*/
						_.each(response, function(group) {
							html += '<option value="'+group.id+'">'+group.name+'</option>';
						});
						$('.sub-group').append(html);
						$('.sub-group').show();
					},
				});
			} else {
				$('.sub-group').html('');
				$('.sub-group').hide();
			}
		},
		
		addUser: function() {
			this.userCounter++;
			
			var user = new User;
			user.set({
				name: user.get('name') + this.userCounter,
				company: 'Payments AS',
			});
			//console.log(user);
			this.collection.add(user);
		},
		
		appendUser: function(user) {
			$('ul.user-list').append('<li>'+user.get('name')+' '+user.get('company')+'</li>');
		},
	});
	
	// test model
	/*var user = new User;
	alert(user);
	alert(user.get('name'));*/
	
	// test view
	var userView = new UserView;
	
});