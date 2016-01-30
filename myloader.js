function make_moreoptions_visible()
{
  var span_moreoptions = document.getElementById('moreoptions');
  span_moreoptions.className="is_on";

  var span_moreoptions = document.getElementById('buttonmoreoptions');
  span_moreoptions.className="is_off";
}


function make_moreoptions_invisible()
{
  var span_moreoptions = document.getElementById('moreoptions');
  span_moreoptions.className="is_off";

  var span_moreoptions = document.getElementById('buttonmoreoptions');
  span_moreoptions.className="is_on";
}


function copyPasteLinkHTML5(data2send)
{
 var copyEvent = new ClipboardEvent('copy', { dataType: 'text/plain', data: data2send } );

 document.dispatchEvent(copyEvent);
}
