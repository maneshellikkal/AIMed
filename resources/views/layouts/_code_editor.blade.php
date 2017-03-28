@push('styles')
<style type="text/css">#code-editor {position: relative; height: 400px;}</style>
@endpush

@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/ace.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.6/theme-pastel_on_dark.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var textarea = $('textarea[name="code"]');
        var editor = ace.edit("code-editor");
        editor.setTheme("ace/theme/monokai");
        editor.getSession().setMode("ace/mode/python");
        editor.getSession().setValue(textarea.val());
        editor.getSession().on('change', function(){
            textarea.val(editor.getSession().getValue());
        });
    });
</script>
@endpush