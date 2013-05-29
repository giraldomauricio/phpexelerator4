/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var lastLoadViewMessage;

function LoadView(pageName)
{
  $.ajax({
    type: "POST",
    url: pageName
  }).done(function( html ) {
    $("#viewLoader").append(html);
  });
}

function LoadAction(pageName, action)
{
  $.ajax({
    type: "POST",
    url: pageName,
    data: { doCall: action }
  }).done(function( html ) {
    $("#viewLoader").append(html);
  });
}