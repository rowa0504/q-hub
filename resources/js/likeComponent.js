export function likeComponent(postId, initialLiked, initialLikesCount) {
    return {
        postId: postId,
        liked: initialLiked,
        likesCount: initialLikesCount,

        toggleLike() {
            let url = `/posts/${this.postId}/like-toggle`;

            fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "liked") {
                        this.liked = true;
                        this.likesCount = data.likes_count;
                    } else if (data.status === "unliked") {
                        this.liked = false;
                        this.likesCount = data.likes_count;
                    } else {
                        alert("Unknown response");
                    }
                })
                .catch(() => alert("Connection error"));
        },
    };
}
