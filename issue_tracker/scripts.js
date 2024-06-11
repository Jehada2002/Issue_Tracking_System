document.getElementById("addIssueForm").addEventListener("submit", function(event) {
    var description = document.getElementById("description").value;
    var severity = document.getElementById("severity").value;

    if (description.trim() === "") {
        alert("Please enter issue description.");
        event.preventDefault();
        return;
    }

    if (severity === "") {
        alert("Please select issue severity.");
        event.preventDefault();
        return;
    }
});
