import HttpClient from '../index'

class PageApi extends HttpClient {
    list(page = 1, query) {
        return this.requestType('get').request(`/pages?page=${page}&${query}`)
    }

    getAllPages() {
        return this.requestType('get').request(`/fetch-all-published-pages`)
    }
    getAllNews() {
        return this.requestType('get').request(`/fetch-all-published-news`)
    }

    get(slug) {
        return this.requestType('get').request(`/pages/${slug}/edit`)
    }

    save(payload) {
        return this.requestType('post').formBody(payload).request(`pages`)
    }

    update(payload) {
        return this.requestType('post').formBody(payload).request(`pages/${payload.id}`)
    }

    translate(payload) {
        return this.requestType('post').formBody(payload).request(`pages/translate/${payload.id}`)
    }


    delete(id) {
        return this.requestType('delete').request(`pages/${id}`)
    }

    savePageIds(payload) {
        return this.requestType('post').formBody(payload).request(`save-page-ids`)
    }
    saveStatus(payload) {
        return this.requestType('post').formBody(payload).request(`save-news-status`)
    }
    deleteNews(id) {
        return this.requestType('delete').request(`delete-news/${id}`)
    }
}

const pageApi = new PageApi()
export default pageApi
