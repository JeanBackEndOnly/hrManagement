    <script>
        // const selectedJobTitle = <?php echo json_encode($signup_data['jobTitle'] ?? '') ?>;
        const selectedJobTitle = <?= json_encode($row["jobTitle"] ?? "") ?>;
        window.signupData = {
            scheduleFrom: <?= json_encode($signup_data['scheduleFrom'] ?? '') ?>,
            scheduleTo: <?= json_encode($signup_data['scheduleTo'] ?? '') ?>
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/../main.js" defer></script>
    <script src="../../assets/js/hr/hrmain.js"></script>
    
</body>
</html>