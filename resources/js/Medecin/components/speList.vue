<template>
    <div class="d-flex speContainer">
        <div class="speListIndex">
            <span>{{index}}</span>
        </div>
        <div class="speListContent">
            <p>{{content}}</p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        index: Number,
        content: String
    }
}
</script>
