// Collapse function for mobile view
app.factory('Collapse', function($window) {
    var isCollapsed = true;
    return {
        getState: function() { return isCollapsed; },
        flipState: function() { if($window.innerWidth < 768) isCollapsed = !isCollapsed; }
    };
});