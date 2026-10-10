<?php
$files = [
    "resources/views/admin/facilities/create.blade.php",
    "resources/views/admin/facilities/edit.blade.php",
    "resources/views/admin/extracurriculars/create.blade.php",
    "resources/views/admin/extracurriculars/edit.blade.php"
];

$newJs = <<<EOT
    $(document).ready(function() {
        var \$iconSelect = $('#icon-select');
        var selectedIcon = \$iconSelect.attr('data-selected') || 'check-circle';
        \$iconSelect.empty();
        
        if (window.feather) {
            Object.keys(window.feather.icons).forEach(function(iconName) {
                var selected = (iconName === selectedIcon) ? 'selected' : '';
                var displayName = iconName.replace(/-/g, ' ').replace(/\b\w/g, function(l) { return l.toUpperCase(); });
                \$iconSelect.append('<option value="' + iconName + '" ' + selected + '>' + displayName + '</option>');
            });
        }

        function formatIcon(icon) {
            if (!icon.id) {
                return icon.text;
            }
            var svg = '';
            if (window.feather && window.feather.icons[icon.id]) {
                svg = window.feather.icons[icon.id].toSvg({ width: 18, height: 18 });
            }
            return $('<span><span style="display:inline-block; vertical-align:middle; width:24px;">' + svg + '</span> <span style="vertical-align:middle;">' + icon.text + '</span></span>');
        }

        \$iconSelect.select2({
            templateResult: formatIcon,
            templateSelection: formatIcon,
            width: '100%'
        });

        \$iconSelect.on('change', function() {
            const val = $(this).val();
            const preview = document.getElementById('icon-preview');
            preview.innerHTML = `<i data-feather="\${val}"></i>`;
            if (window.feather) feather.replace();
        });
        
        \$iconSelect.trigger('change');
    });
EOT;

foreach ($files as $file) {
    $content = file_get_contents($file);
    // Replace the javascript block
    $pattern = '/\$\(document\)\.ready\(function\(\) \{.*?\n\s*\}\);\s*(\/\/ Media Picker Logic)/s';
    $newContent = preg_replace($pattern, $newJs . "\n\n    $1", $content);
    file_put_contents($file, $newContent);
    echo "Updated JS in $file\n";
}
