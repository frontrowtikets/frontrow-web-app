<script>
import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/page-header.vue";
import img2 from "../../../images/small/img-2.jpg";
import avatar2 from "../../../images/users/avatar-2.jpg";

export default {
    page: {
        title: "Blog-detail",
    },
    components: {
        Layout,
        PageHeader,
    },
    data() {
        return {
            img2,
            avatar2,
            title: "Blog Detail",
            items: [
                {
                    text: "Blog",
                    href: "/",
                },
                {
                    text: "Blog Detail",
                    active: true,
                },
            ],
        };
    },
};
</script>

<template>
    <Layout>
        <PageHeader :title="title" :items="items" />
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="pt-3">
                            <div class="row justify-content-center">
                                <div class="col-xl-8">
                                    <div>
                                        <div class="text-center">
                                            <div class="mb-4">
                                                <a href="#" class="badge bg-light font-size-12">
                                                    <i class="align-middle bx bx-purchase-tag-alt text-muted me-1"></i>
                                                    Project
                                                </a>
                                            </div>
                                            <h4>Beautiful Day with Friends</h4>
                                            <p class="mb-4 text-muted"><i class="mdi mdi-calendar me-1"></i> 10 Apr, 2020</p>
                                        </div>

                                        <hr />
                                        <div class="text-center">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div>
                                                        <p class="mb-2 text-muted">Categories</p>
                                                        <h5 class="font-size-15">Project</h5>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="mt-4 mt-sm-0">
                                                        <p class="mb-2 text-muted">Date</p>
                                                        <h5 class="font-size-15">10 Apr, 2020</h5>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="mt-4 mt-sm-0">
                                                        <p class="mb-2 text-muted">Post by</p>
                                                        <h5 class="font-size-15">Gilbert Smith</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="my-5">
                                            <img :src="img2" alt="" class="mx-auto img-thumbnail d-block" />
                                        </div>

                                        <hr />

                                        <div class="mt-4">
                                            <div class="text-muted font-size-14">
                                                <p>
                                                    Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut
                                                    labore et dolore magnam enim ad minima veniam quis
                                                </p>

                                                <p class="mb-4">
                                                    Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea reprehenderit qui in ea voluptate
                                                    velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio
                                                    dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate
                                                    non provident, similique sunt
                                                </p>

                                                <blockquote class="p-4 mb-4 border rounded border-light">
                                                    <div class="d-flex">
                                                        <div class="me-3">
                                                            <i class="bx bxs-quote-alt-left text-dark font-size-24"></i>
                                                        </div>
                                                        <div>
                                                            <p class="mb-0">
                                                                At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium deleniti atque corrupti quos dolores et quas
                                                                molestias excepturi sint quidem rerum facilis est
                                                            </p>
                                                        </div>
                                                    </div>
                                                </blockquote>

                                                <p>
                                                    Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores
                                                    repellat. Sed ut perspiciatis unde omnis iste natus error sit
                                                </p>

                                                <div class="mt-4">
                                                    <h5 class="mb-3">Title:</h5>

                                                    <div>
                                                        <div class="row">
                                                            <div class="col-lg-4 col-sm-6">
                                                                <div>
                                                                    <ul class="pl-4">
                                                                        <li class="py-1">Donec sodales sagittis</li>
                                                                        <li class="py-1">Sed consequat leo eget</li>
                                                                        <li class="py-1">Aliquam lorem ante</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-sm-6">
                                                                <div>
                                                                    <ul class="pl-4">
                                                                        <li class="py-1">Aenean ligula eget</li>
                                                                        <li class="py-1">Cum sociis natoque</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr />

                                            <div class="mt-5">
                                                <h5 class="font-size-15">
                                                    <i class="align-middle bx bx-message-dots text-muted me-1"></i>
                                                    Comments :
                                                </h5>

                                                <div>
                                                    <div class="py-3 d-flex">
                                                        <div class="avatar-xs me-3">
                                                            <div class="avatar-title rounded-circle bg-light text-primary">
                                                                <i class="bx bxs-user"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="mb-1 font-size-14">
                                                                Delores Williams
                                                                <small class="text-muted float-end">1 hr Ago</small>
                                                            </h5>
                                                            <p class="text-muted">
                                                                If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual
                                                            </p>
                                                            <div>
                                                                <a href="javascript: void(0);" class="text-success"><i class="mdi mdi-reply"></i> Reply</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="py-3 d-flex border-top">
                                                        <div class="avatar-xs me-3">
                                                            <img :src="avatar2" alt="" class="img-fluid d-block rounded-circle" />
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="mb-1 font-size-14">
                                                                Clarence Smith
                                                                <small class="text-muted float-end">2 hrs Ago</small>
                                                            </h5>
                                                            <p class="text-muted">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet</p>
                                                            <div>
                                                                <a href="javascript: void(0);" class="text-success"><i class="mdi mdi-reply"></i> Reply</a>
                                                            </div>

                                                            <div class="pt-3 d-flex">
                                                                <div class="avatar-xs me-3">
                                                                    <div class="avatar-title rounded-circle bg-light text-primary">
                                                                        <i class="bx bxs-user"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <h5 class="mb-1 font-size-14">
                                                                        Silvia Martinez
                                                                        <small class="text-muted float-end">2 hrs Ago</small>
                                                                    </h5>
                                                                    <p class="text-muted">To take a trivial example, which of us ever undertakes laborious physical exercise</p>
                                                                    <div>
                                                                        <a href="javascript: void(0);" class="text-success"><i class="mdi mdi-reply"></i> Reply</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="py-3 d-flex border-top">
                                                        <div class="avatar-xs me-3">
                                                            <div class="avatar-title rounded-circle bg-light text-primary">
                                                                <i class="bx bxs-user"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="mb-1 font-size-14">
                                                                Keith McCoy
                                                                <small class="text-muted float-end">12 Aug</small>
                                                            </h5>
                                                            <p class="text-muted">Donec posuere vulputate arcu. phasellus accumsan cursus velit</p>
                                                            <div>
                                                                <a href="javascript: void(0);" class="text-success"><i class="mdi mdi-reply"></i> Reply</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <h5 class="mb-3 font-size-16">Leave a Message</h5>

                                                <form>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="commentname-input">Name</label>
                                                                <input type="text" class="form-control" id="commentname-input" placeholder="Enter name" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="commentemail-input">Email</label>
                                                                <input type="email" class="form-control" id="commentemail-input" placeholder="Enter email" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="commentmessage-input">Message</label>
                                                        <textarea class="form-control" id="commentmessage-input" placeholder="Your message..." rows="3"></textarea>
                                                    </div>

                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-success w-sm">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </Layout>
</template>
