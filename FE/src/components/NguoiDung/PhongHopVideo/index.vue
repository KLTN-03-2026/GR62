<template>
    <div class="vh-100 d-flex flex-column bg-dark" style="background-color: #0f172a !important;">
        <header class="p-3 d-flex justify-content-between align-items-center position-absolute w-100 top-0 z-3"
            style="background: linear-gradient(to bottom, rgba(0,0,0,0.7) 0%, transparent 100%);">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-success rounded-circle" style="width: 10px; height: 10px; box-shadow: 0 0 10px #22c55e;">
                </div>
                <h6 class="mb-0 text-white fw-bold text-shadow">Phòng: {{ roomId }}</h6>
            </div>
            <div
                class="text-white bg-dark bg-opacity-50 px-3 py-1 rounded-pill border border-secondary small fw-medium backdrop-blur">
                <i class='bx bx-time-five me-1'></i> Đang diễn ra
            </div>
        </header>

        <main class="flex-grow-1 position-relative p-2 p-md-4 mt-5 d-flex align-items-center justify-content-center">
            <div id="video-grid" class="video-grid w-100 h-100">
                <div id="local-video-wrapper" class="video-wrapper shadow-lg">
                    <div class="w-100 h-100 bg-secondary position-relative">
                        <div v-if="!cameraReady" class="position-absolute top-50 start-50 translate-middle z-3">
                            <span class="spinner-border text-light"></span>
                        </div>

                        <div id="local-video" class="w-100 h-100 position-absolute top-0 start-0"></div>
                    </div>

                    <div class="user-label">
                        <i class='bx bx-user-circle'></i> Bạn
                        <i v-if="!isMicOn" class='bx bx-microphone-off text-danger ms-2' title="Mic đang tắt"></i>
                        <i v-else class='bx bx-microphone text-success ms-2' title="Mic đang bật"></i>
                    </div>
                </div>
            </div>
        </main>

        <footer class="position-absolute bottom-0 w-100 mb-4 d-flex justify-content-center z-3">
            <div
                class="bg-dark bg-opacity-75 backdrop-blur px-4 py-3 rounded-pill shadow-lg border border-secondary d-flex gap-3 align-items-center">

                <button @click="toggleMic"
                    :class="['btn rounded-circle tool-btn shadow-sm', isMicOn ? 'btn-light' : 'btn-danger']"
                    :title="isMicOn ? 'Tắt Micro' : 'Bật Micro'">
                    <i :class="['fs-4', isMicOn ? 'bx bx-microphone' : 'bx bxs-microphone-off']"></i>
                </button>

                <button @click="toggleCamera"
                    :class="['btn rounded-circle tool-btn shadow-sm', isCameraOn ? 'btn-light' : 'btn-danger']"
                    :title="isCameraOn ? 'Tắt Camera' : 'Bật Camera'">
                    <i :class="['fs-4', isCameraOn ? 'bx bx-video' : 'bx bx-video-off']"></i>
                </button>

                <button @click="toggleScreenShare"
                    :class="['btn rounded-circle tool-btn shadow-sm', isSharingScreen ? 'btn-primary' : 'btn-light']"
                    :title="isSharingScreen ? 'Dừng chia sẻ màn hình' : 'Chia sẻ màn hình'">
                    <i :class="['fs-4', isSharingScreen ? 'bx bx-stop-circle' : 'bx bx-desktop']"></i>
                </button>

                <button @click="openSettings" class="btn btn-secondary rounded-circle tool-btn shadow-sm"
                    title="Cài đặt Âm thanh">
                    <i class='bx bx-slider-alt fs-4'></i>
                </button>

                <div class="vr bg-secondary mx-2"></div>

                <button @click="roiPhong"
                    class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2"
                    style="height: 50px;" title="Rời khỏi phòng họp">
                    <i class='bx bx-phone-off fs-5'></i> Rời đi
                </button>
            </div>
        </footer>

        <div v-if="showSettings" class="modal-overlay d-flex justify-content-center align-items-center"
            style="z-index: 9999;">
            <div class="bg-dark border border-secondary rounded-4 p-4 shadow-lg text-white"
                style="width: 400px; max-width: 90%;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0 fw-bold"><i class='bx bx-cog text-primary me-2'></i> Cài đặt thiết bị</h5>
                    <button @click="showSettings = false" class="btn-close btn-close-white"></button>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">CHỌN MICRO (ĐẦU VÀO)</label>
                    <select class="form-select bg-dark text-white border-secondary" v-model="selectedMic"
                        @change="switchDevice('audioinput', selectedMic)">
                        <option v-for="device in audioInputs" :key="device.deviceId" :value="device.deviceId">
                            {{ device.label || 'Micro mặc định' }}
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary small fw-bold">CHỌN LOA (ĐẦU RA)</label>
                    <select class="form-select bg-dark text-white border-secondary" v-model="selectedSpeaker"
                        @change="switchDevice('audiooutput', selectedSpeaker)">
                        <option v-for="device in audioOutputs" :key="device.deviceId" :value="device.deviceId">
                            {{ device.label || 'Loa mặc định' }}
                        </option>
                    </select>
                </div>

                <button @click="showSettings = false" class="btn btn-primary w-100 rounded-pill fw-bold">Hoàn
                    tất</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { Room, RoomEvent, Track } from 'livekit-client';
import { markRaw } from 'vue';

export default {
    name: 'PhongHopVideo',
    data() {
        return {
            roomId: this.$route.params.id || this.$route.params.maPhong,
            room: null,
            cameraReady: false,
            isMicOn: true,
            isCameraOn: true,
            isSharingScreen: false,

            // State cho Cài đặt thiết bị
            showSettings: false,
            audioInputs: [],
            audioOutputs: [],
            selectedMic: '',
            selectedSpeaker: ''
        };
    },
    async mounted() {
        const token = sessionStorage.getItem('livekit_token');
        const livekitUrl = import.meta.env.VITE_LIVEKIT_URL;

        if (!token) {
            if (this.$toast) this.$toast.error("Bạn chưa có quyền vào phòng!");
            this.$router.push('/nguoi-dung/trang-chinh');
            return;
        }

        try {
            this.room = markRaw(new Room({
                adaptiveStream: true,
                dynacast: true,
            }));

            // Lắng nghe người khác vào
            this.room.on(RoomEvent.TrackSubscribed, (track, publication, participant) => {
                if (track.kind === 'video') {
                    // Nếu là track màn hình chia sẻ
                    if (track.source === Track.Source.ScreenShare) {
                        this.attachRemoteVideo(track, participant, true);
                    } else {
                        this.attachRemoteVideo(track, participant, false);
                    }
                } else if (track.kind === 'audio') {
                    track.attach();
                }
            });

            this.room.on(RoomEvent.TrackUnsubscribed, (track, publication, participant) => {
                track.detach();
                const videoEl = document.getElementById(track.source === Track.Source.ScreenShare ? `screen-${participant.sid}` : `video-${participant.sid}`);
                if (videoEl) videoEl.remove();
            });

            // HIỆU ỨNG PHÁT SÁNG KHI ĐANG NÓI (SPEAKING)
            this.room.on(RoomEvent.ActiveSpeakersChanged, (speakers) => {
                // Tắt viền tất cả mọi người trước
                document.querySelectorAll('.video-wrapper, .video-container').forEach(el => el.classList.remove('speaking-border'));

                // Bật viền cho người đang phát ra âm thanh
                speakers.forEach(speaker => {
                    const elId = speaker.isLocal ? 'local-video-wrapper' : `video-${speaker.sid}`;
                    const el = document.getElementById(elId);
                    if (el) el.classList.add('speaking-border');
                });
            });

            await this.room.connect(livekitUrl, token);

            await this.room.localParticipant.enableCameraAndMicrophone();
            this.cameraReady = true;

            const localVideoTrack = this.room.localParticipant.getTrackPublication(Track.Source.Camera);
            if (localVideoTrack && localVideoTrack.videoTrack) {
                const videoElement = localVideoTrack.videoTrack.attach();
                videoElement.style.width = '100%';
                videoElement.style.height = '100%';
                videoElement.style.objectFit = 'cover';
                videoElement.style.transform = 'scaleX(-1)';

                const localContainer = document.getElementById('local-video');
                localContainer.appendChild(videoElement);
            }

        } catch (error) {
            console.error("Lỗi kết nối phòng:", error);
            if (this.$toast) this.$toast.error("Không thể kết nối đến máy chủ Video.");
        }
    },
    methods: {
        attachRemoteVideo(track, participant, isScreenShare = false) {
            const videoGrid = document.getElementById('video-grid');

            const wrapper = document.createElement('div');
            // Cấp ID riêng biệt để phân biệt mặt người và màn hình họ chia sẻ
            wrapper.id = isScreenShare ? `screen-${participant.sid}` : `video-${participant.sid}`;
            wrapper.className = 'video-container position-relative rounded-4 overflow-hidden shadow bg-secondary';

            const labelWrapper = document.createElement('div');
            labelWrapper.className = 'position-absolute bottom-0 start-0 p-2 z-3 d-flex align-items-center gap-2';

            let labelText = isScreenShare ? `${participant.identity} (Màn hình)` : participant.identity;
            labelWrapper.innerHTML = `<span class="badge bg-dark px-3 py-2 rounded-pill shadow border border-secondary">${labelText}</span>`;

            const videoElement = track.attach();
            videoElement.style.width = '100%';
            videoElement.style.height = '100%';
            // Màn hình chia sẻ thì không crop (contain), Camera thì crop cho đẹp (cover)
            videoElement.style.objectFit = isScreenShare ? 'contain' : 'cover';
            // Không lật ngược (scaleX) đối với màn hình chia sẻ
            if (!isScreenShare) videoElement.style.transform = 'scaleX(-1)';

            wrapper.appendChild(videoElement);
            wrapper.appendChild(labelWrapper);
            videoGrid.appendChild(wrapper);
        },
        async toggleMic() {
            this.isMicOn = !this.isMicOn;
            await this.room.localParticipant.setMicrophoneEnabled(this.isMicOn);
        },
        async toggleCamera() {
            this.isCameraOn = !this.isCameraOn;
            await this.room.localParticipant.setCameraEnabled(this.isCameraOn);
        },
        async toggleScreenShare() {
            try {
                this.isSharingScreen = !this.isSharingScreen;
                await this.room.localParticipant.setScreenShareEnabled(this.isSharingScreen);
            } catch (error) {
                console.error("Lỗi chia sẻ màn hình:", error);
                this.isSharingScreen = false;
                if (this.$toast) this.$toast.error("Đã hủy chia sẻ màn hình.");
            }
        },
        // --- CÁC HÀM XỬ LÝ THIẾT BỊ ÂM THANH ---
        async openSettings() {
            this.showSettings = true;
            try {
                // Xin quyền lấy danh sách để đọc được Label (Tên mic/loa)
                await navigator.mediaDevices.getUserMedia({ audio: true });
                const devices = await navigator.mediaDevices.enumerateDevices();

                this.audioInputs = devices.filter(d => d.kind === 'audioinput');
                this.audioOutputs = devices.filter(d => d.kind === 'audiooutput');

                // Set giá trị mặc định là thiết bị đang được kích hoạt
                this.selectedMic = this.room?.getActiveDevice('audioinput') || this.audioInputs[0]?.deviceId || '';
                this.selectedSpeaker = this.room?.getActiveDevice('audiooutput') || this.audioOutputs[0]?.deviceId || '';
            } catch (err) {
                console.error("Không thể lấy danh sách thiết bị:", err);
            }
        },
        async switchDevice(kind, deviceId) {
            if (this.room) {
                await this.room.switchActiveDevice(kind, deviceId);
                if (this.$toast) this.$toast.success("Đã chuyển đổi thiết bị âm thanh!");
            }
        },
        roiPhong() {
            // Lấy thông tin user và ID phòng
            const user = JSON.parse(localStorage.getItem('thong_tin_user'));
            const id_phong_that = sessionStorage.getItem('id_phong_hop');
            const apiUrl = import.meta.env.VITE_API_URL;

            // Bắn API lưu lịch sử rời phòng (chạy ngầm, không cần await để tránh chờ đợi)
            if (user && id_phong_that) {
                let data = {
                    id_nguoi_dung: user.id,
                    id_phong_hop: id_phong_that,
                    xac_thuc_khuon_mat: 1,
                    is_vi_pham: 0,
                    is_nguoi_dung: 1,
                    is_active: 0, // 0 vì đang rời đi
                    trang_thai: 1
                };

                axios
                    .post(`${apiUrl}/chi-tiet-phong-hop/create`, data)
                    .catch(err => console.error("Lỗi lưu lịch sử:", err));
            }
            // Xử lý ngắt kết nối LiveKit và dọn dẹp
            if (this.room) {
                this.room.disconnect();
            }
            sessionStorage.removeItem('livekit_token');
            sessionStorage.removeItem('id_phong_hop'); // Dọn dẹp luôn ID phòng
            this.$router.push('/nguoi-dung/trang-chinh');
        }
    },
    beforeUnmount() {
        if (this.room) {
            this.room.disconnect();
        }
    }
}
</script>

<style scoped>
.video-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 16px;
    align-content: center;
    justify-content: center;
}

.video-wrapper,
.video-container {
    position: relative;
    width: 100%;
    height: 100%;
    max-height: 80vh;
    border-radius: 16px;
    overflow: hidden;
    background-color: #1e293b;
    border: 3px solid transparent;
    /* Chuẩn bị cho hiệu ứng nói */
    aspect-ratio: 16 / 9;
    transition: all 0.3s ease;
}

/* HIỆU ỨNG PHÁT SÁNG KHI CÓ NGƯỜI NÓI (Cực kỳ quan trọng cho UX) */
.speaking-border {
    border-color: #22c55e !important;
    box-shadow: 0 0 20px rgba(34, 197, 94, 0.6) !important;
    transform: scale(1.02);
}

.user-label {
    position: absolute;
    bottom: 12px;
    left: 12px;
    background-color: rgba(0, 0, 0, 0.6);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
    backdrop-filter: blur(4px);
    z-index: 10;
}

.backdrop-blur {
    backdrop-filter: blur(10px);
}

.tool-btn {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s;
}

.tool-btn:hover {
    transform: scale(1.1);
}

.text-shadow {
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
}

/* CSS cho Modal Cài đặt */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(5px);
}
</style>