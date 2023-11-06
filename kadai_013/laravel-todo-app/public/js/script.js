// タグの編集用フォーム
const editTagForm = document.forms.editTagForm;

// タグの削除用フォーム
const deleteTagForm = document.forms.deleteTagForm;

// 削除の確認メッセージ
const deleteMessage = document.getElementById('deleteTagModalLabel');

// タグの編集用モーダルを開く時の処理
// Bootstrapで実装したモーダルに対してのイベント処理→show.bs.modal
// data-tag-id属性やdata-tag-name属性のようなカスタムデータ属性を取得  →datasetプロパティを使う
// ex)data-tag-id:HTML要素.dataset.tagId
document.getElementById('editTagModal').addEventListener('show.bs.modal', (event) => {
    let tagButton = event.relatedTarget;
    let tagId = tagButton.dataset.tagId;
    let tagName = tagButton.dataset.tagName;

    editTagForm.action = `tags/${tagId}`;
    editTagForm.name.value = tagName;
});

// タグの削除用モーダルを開く時の処理
document.getElementById('deleteTagModal').addEventListener('show.bs.modal', (event) => {
    let deleteButton = event.relatedTarget;
    let tagId = deleteButton.dataset.tagId;
    let tagName = deleteButton.dataset.tagName;

    deleteTagForm.action = `tags/${tagId}`;
    deleteMessage.textContent = `｢${tagName}」を削除してもよろしいですか？`
});
