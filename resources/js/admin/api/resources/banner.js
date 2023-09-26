import HttpClient from '../index'

class BannerApi extends HttpClient {

    list(page = 1, query) {
        return this.requestType('get').request(`/banner?page=${page}&${query}`)
    }
    getAllNews() {
        return this.requestType('get').request(`/fetch-all-published-banner`)
    }

    get(slug) {
        return this.requestType('get').request(`/banner/${slug}/edit`)
    }

    save(payload) {
        return this.requestType('post').formBody(payload).request(`banner`)
    }

    update(payload) {
        return this.requestType('post').formBody(payload).request(`banner/${payload.id}`)
    }

    delete(id) {
        return this.requestType('delete').request(`banner/${id}`)
    }

    saveStatus(payload) {
        return this.requestType('post').formBody(payload).request(`save-banner-status`)
    }
    deleteNews(id) {
        return this.requestType('delete').request(`delete-banner/${id}`)
    }
}

const bannerApi = new BannerApi()
export default bannerApi
