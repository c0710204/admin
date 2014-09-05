/* linerviz js template */
var data=[];
var width = 960,
    height = 500;

//var color = d3.scale.ordinal();
var color = d3.scale.category10();

var vis = d3.select("#chart").append("svg")
    .attr("width", width)
    .attr("height", height);


function getData(){

	var p = {
		'do':'getData'
		//'categId':$('#categs').val(),
		//'date_from':$('#date1').val(),
		//'date_to':$('#date2').val()
	};

	$("#more").load("ctrl.php",p,function(x){
		try{
			eval(x);

			var parseDate = d3.time.format("%Y-%m-%d").parse;

			data.forEach(function(d) {
		    	d.date = parseDate(d.date);
			});

			//update();
			updateBars();
			$("#more").html(data.length + " nodes");
		}
		catch(e){
			console.log( "getData() error" , e.message );
		}
	});
}



function updateBars(){

	//console.log("updateBars()");

	d3.selectAll(".axis, .line, g").remove();

	var nMax = d3.max(data,function(d){return d.n;});

	var barWidth = width / (data.length);

	var fd = d3.time.format("%a %d");//%d %b %Y

	//console.log("nMax", nMax, barWidth);

	var yScale = d3.scale.linear().range([0, 300]).domain([0, nMax]);

	var tDomain=d3.extent(data,function(d){return d.date;});
	//console.log(tDomain);

	var xScale = d3.time.scale().range([ 10, 940 ]);
	xScale.domain(tDomain);

	var xAxis = d3.svg.axis().scale(xScale)
		.tickSize(0)
		.tickFormat(function(d){return d3.time.format("%d %b")(d);})
		//.orient("bottom")

    vis.append("g")
        .attr("class", "axis")
        .attr("transform", "translate(0,304)")
        .call(xAxis)
        .selectAll("text")
        .style("text-anchor", "end")
        .attr("dx", "-.2em")
     	.attr("dy", ".15em")
        .attr("transform", function(d){return "rotate(-90)"})
        //.attr("fill", "#999");


	//override css
    vis.selectAll('.axis line, .axis path').style({ 'stroke': 'Black', 'fill': 'none', 'stroke-width': '1px'});


	//var colorId=$("#categt")

	// http://bost.ocks.org/mike/bar/3/
	var bar = vis.selectAll("g.bar").data(data)
	    .enter().append("g")
	    .attr("class", "bar")
	    .attr("transform", function(d, i) { return "translate(" + (i*barWidth) + ",0)"; })
	    .on("mouseover",mouseover)
	    .on("mousemove",mousemove)
	    .on("mouseout", mouseout );


	bar.append("rect")
      .attr("y", function(d){return 300-yScale(d.n) })
      .attr("height", function(d) { return yScale(d.n); })
      .attr("width", barWidth - 1)
      .attr("fill", color( $('#categs').val() ));

    //values as text
    bar.append("text")
      .attr("x", 1)
      .attr("y", function(d){return 300-yScale(d.n)+2} )
      .attr("dy", ".75em")
      .attr("fill", "#fff")
      .style("font-size","14px")
      .text(function(d) { if(d.n>0)return d.n; });

    //dates
    /*
	bar.append("text")
      .attr("x", 0)

      .attr("dy", ".75em")
      .attr("fill", "#999")
      .attr("y", 302 )
      .text(function(d,i){
      	//if(data.length<32)return fd(d.date);
      	return i;
      });
	*/
}





/**
 * Tooltip
 */
var ttdiv = d3.select("body").append("div")
.attr("class", "tooltip")
.style("opacity", 1e-6);

function mouseover(){
    ttdiv.transition().duration(200).style("opacity", 1);
}

var formatDate = d3.time.format("%a %d %b %Y");

function mousemove(d,i){
    var html = "";
    html+="<b>" + formatDate(d.date) + "</b><br />\n";
    html+="<hr style='margin-top:4px;margin-bottom:4px'/>\n";
    html+="<b>" + d.n + "</b><br />\n";
    ttdiv.html( html )
  .style("left", ttleft )
  .style("top", (d3.event.pageY + 10 ) + "px");
}

function mouseout(){
    ttdiv.transition().duration(200).style("opacity", 1e-6);
}

function ttleft(){
	var max = $("body").width()-$("div.tooltip").width() - 20;
    return  Math.min( max , d3.event.pageX + 10 ) + "px";
}



/**
 * Go baby go
 */
$(document).ready(function(){
    console.log('ready');
	getData();
});