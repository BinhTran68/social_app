import axios from 'axios';

export const CLOUDINARY_UPLOAD_PRESET = 'social_app_img'
export const CLOUDINARY_NAME = 'dbqssdrgd'
export const BASE_URL = 'http://socical-app.test'

export const uploadFileToCloud = (formData, folder_name) => {
    return axios.post(`https://api.cloudinary.com/v1_1/${CLOUDINARY_NAME}/image/upload?folder=${folder_name}`, formData)
        .then((response) => {
            return response.data.secure_url
        }).catch(e => {
            console.log(e)
            return null
        })
}
