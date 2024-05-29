<template>
    <div>
        <h1>{{ pornstar.name }}</h1>
        <img :src="`data:image/jpeg;base64,${image}`" alt="Pornstar Image" />
    </div>
</template>

<script>
export default {
    props: {
        pornstar: Object,
        image: String,
    },
};
</script>
