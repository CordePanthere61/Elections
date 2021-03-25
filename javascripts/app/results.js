let container = document.querySelector('.container')
$(document).ready(function () {
    showGraph();
});

function showGraph() {
    {
        $.post("./resultsData.php",
            function (data)
            {
                console.log(data);
                console.log(countDistinctPolls(data, data.length))

                var pollIds = countDistinctPolls(data, data.length)

                for (i in pollIds) {
                    let div = document.createElement("div")
                    div.id = "graphCanvas" + i
                    container.append(div)



                    //var occurences = findOccurences()
                }
                console.log(findValues(1 , data))

                // for (var i in data) {
                //     name.push(data[i].student_name);
                //     marks.push(data[i].marks);
                // }

                // var chartdata = {
                //     labels: name,
                //     datasets: [
                //         {
                //             label: 'Student Marks',
                //             backgroundColor: '#49e2ff',
                //             borderColor: '#46d5f1',
                //             hoverBackgroundColor: '#CCCCCC',
                //             hoverBorderColor: '#666666',
                //             data: marks
                //         }
                //     ]
                // };
                //
                // var graphTarget = $("#graphCanvas");
                //
                // var barGraph = new Chart(graphTarget, {
                //     type: 'bar',
                //     data: chartdata
                // });
            });
    }
}

function findValues(pollId, data) {
    var res = []
    for (let i = 0; i < data.length; i++) {
        let j = 0;
        for (j = 0; j < i; j++) {
            if (data[i].pollId === pollId && data[i].value === data[j].value)
                break;
        }
        if (i === j) {
            res.push(data[i].value)
        }
    }
    return res
}

function countDistinctPolls(arr, n)
{
    let res = [arr[0].pollId];

    for (let i = 1; i < n; i++) {
        let j = 0;
        for (j = 0; j < i; j++)
            if (arr[i].pollId === arr[j].pollId)
                break;

        if (i === j)
            res.push(arr[i].pollId);
    }
    return res;
}
