/* d3js jambon template */
var data=[];
var width = 960,
    height = 400;

//var color = d3.scale.ordinal().range(mnc);
var color = d3.scale.category20c();

var vis = d3.select("#chart").append("svg")
    .attr("width", width)
    .attr("height", height);


function getData(){
	
	//console.log('getData()');
	$('#boxgraph .box-title').html("<i class='fa fa-bar-chart-o'></i> Registrations "+$('#dateto').val());

	var p = {
		'do':'d3Data',
		//'date_from':$('#datefrom').val(),
		'date_range':$('#dateto').val()
	};
	
	$('#boxgraph .overlay, #boxgraph .loading-img').show();//loading
	
	$("#more").load("ctrl.php",p,function(x){
		try{
			data=eval(x);

			var parseDate = d3.time.format("%Y-%m-%d").parse;

			data.forEach(function(d) {
		    	d.date = parseDate(d.date);
			});

			//update();
			updateBars();
			$("#more").html(data.length + " nodes");
			$('#boxgraph .overlay, #boxgraph .loading-img').hide();
		}
		catch(e){
			$('#boxgraph .overlay, #boxgraph .loading-img').hide();
			console.log( "getData() error" , e.message );
			alert(e.message);
		}
	});
}



function updateBars(){

	//console.log("updateBars()",data);

	d3.selectAll(".axis, .line, g, text, line").remove();

	var nMax = d3.max(data,function(d){return d.n;});

	var barWidth = width / (data.length);

	var fd = d3.time.format("%a %d");//%d %b %Y

	//console.log("nMax", nMax, barWidth);

	var yScale = d3.scale.linear().range([20, 322]).domain([nMax,0]);

	var tDomain=d3.extent(data,function(d){return d.date;});
	//console.log('tDomain', tDomain);

	var xScale = d3.time.scale().range([ 30, 940 ]);
	xScale.domain(tDomain);

	var xAxis = d3.svg.axis().scale(xScale)
		.tickSize(0)
		.tickFormat(function(d){return d3.time.format("%d %b")(d);})
		//.orient("bottom")

    vis.append("g")
        .attr("class", "axis")
        .attr("transform", "translate(0,324)")
        .call(xAxis)
        .selectAll("text")
        .style("text-anchor", "end")
        .attr("dx", "-.2em")
     	.attr("dy", ".15em")
        .attr("transform", function(d){return "rotate(-90)"})
        //.attr("fill", "#999");


	//override css
    vis.selectAll('.axis line, .axis path').style({ 'stroke': 'Black', 'fill': 'none', 'stroke-width': '1px'});


	//background ticks
	var ls = vis.selectAll("line.rule")
	    .data(yScale.ticks(5))
	    .enter().append("svg:line")
	    .attr("x1", 25)
	    .attr("x2", 960)
	    .attr("y1", function(d){return yScale(d)})
	    .attr("y2", function(d){return yScale(d)})
	    .attr("stroke", function(d){if(d!=0)return "#ccc"});
	

	vis.selectAll("text.rule")
     .data(yScale.ticks(5))
   	.enter().append("svg:text")
     .attr("class", "rule")
     .attr("x", 10)
     .attr("y", function(d){return yScale(d)+4})
     .attr("dy", -3)
     .attr("text-anchor", "middle")
     .text(function(d){if(d!=0)return d;});


	// http://bost.ocks.org/mike/bar/3/
	var bar = vis.selectAll("g.bar").data(data)
	    .enter().append("g")
	    .attr("class", "bar")
	    .attr("transform", function(d, i) { return "translate(" + (i*barWidth)+15 + ",0)"; })
	    .on("mouseover",mouseover)
	    .on("mousemove",mousemove)
	    .on("mouseout", mouseout );

	bar.append("rect")
      .attr("y", function(d){return yScale(d.n) })
      .attr("height", function(d) { return 322-yScale(d.n); })
      .attr("width", barWidth - 1);
      //.attr("fill", color(0));

    //values as text
    bar.append("text")
      .attr("x", 1)
      .attr("y", function(d){return yScale(d.n)-12} )
      .attr("dy", ".75em")
      .attr("fill", "#000")
      .style("font-size","12px")
      .text(function(d) { if(d.n>0)return d.n; });
	
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
    html+="<b>" + d.n + "</b> registrations<br />\n";
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

    //console.log('ready');

    $('#categs,#date1,#date2').change(function(){getData();});

    getData();

});