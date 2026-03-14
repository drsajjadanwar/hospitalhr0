document.addEventListener('DOMContentLoaded', function() {
  const elems = document.querySelectorAll('.sidenav');
  const instances = M.Sidenav.init(elems, {edge: 'right', draggable: true});

  // Close sidenav when clicking anywhere outside
  document.body.addEventListener('click', function(e) {
    if (!e.target.closest('.sidenav') && !e.target.closest('.sidenav-trigger')) {
      instances.forEach(instance => instance.close());
    }
  });
});
