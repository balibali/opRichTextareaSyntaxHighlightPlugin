function op_mce_insert_tagname_block(id, tagname, opt, start, end)
{
  opt = opt || "";

  var elm = document.getElementById(id);

  var selection = new Selection(elm);
  var pos = selection.create();
  elm.focus();

  start = (start == null || start == undefined) ? pos.start : start;
  end   = (end == null || end == undefined)     ? pos.end   : end;

  var replace = "<" + tagname + opt + ">" + "\n" + elm.value.substring(start, end) + "\n" + "</" + tagname + ">";

  var head = elm.value.substring(0, start);
  var tail = elm.value.substring(end, elm.value.length);
  elm.value =  head + replace + tail;
}
