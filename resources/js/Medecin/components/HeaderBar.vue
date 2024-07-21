<template>
    <el-popover 
    placement="right-start"
    :title="HelperTextTitle"
    :width="450"
    trigger="hover"
    :content="HelperTextContent"
    >
    <template #reference>
        <div>
            <button type="button" class="btn btn-secondary btn-lg m-2">Aide ?</button>
        </div>
    </template>
    </el-popover>
</template>

<script>
export default {
    props: {
        HelperTextTitle: String,
        HelperTextContent: String,
    }
}
</script>