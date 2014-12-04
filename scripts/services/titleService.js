// Dynamic title functionality
app.factory('titleService', function() {
    var title = 'BillSplit';
    return {
        title: function() { return title; },
        setTitle: function(newTitle) { title = newTitle; }
    };
});