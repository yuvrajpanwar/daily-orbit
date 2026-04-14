@extends('admin/admin-layout/admin-app')

@push('css')
    <style>
        tr > td { cursor: pointer; }
        tr > :last-child { white-space: nowrap; }

        /* ── Chat Modal Thread ───────────────────────────── */
        #chatModal .modal-dialog { max-width: 680px; }

        #chat-thread {
            max-height: 480px;
            overflow-y: auto;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .chat-bubble-row {
            display: flex;
            margin-bottom: 0.85rem;
            gap: 0.6rem;
        }

        .chat-bubble-row.user  { flex-direction: row-reverse; }
        .chat-bubble-row.assistant { flex-direction: row; }

        .chat-bubble {
            max-width: 75%;
            padding: 0.55rem 0.9rem;
            border-radius: 14px;
            font-size: 0.92rem;
            line-height: 1.5;
            position: relative;
        }

        .chat-bubble-row.user .chat-bubble {
            background: #0d6efd;
            color: #fff;
            border-bottom-right-radius: 4px;
        }

        .chat-bubble-row.assistant .chat-bubble {
            background: #fff;
            color: #212529;
            border: 1px solid #dee2e6;
            border-bottom-left-radius: 4px;
        }

        .chat-bubble-time {
            display: block;
            font-size: 0.72rem;
            opacity: 0.65;
            margin-top: 4px;
            text-align: right;
        }

        .chat-role-label {
            font-size: 0.72rem;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 2px;
            padding: 0 2px;
            align-self: flex-end;
        }

        #chat-thread::-webkit-scrollbar { width: 5px; }
        #chat-thread::-webkit-scrollbar-track { background: transparent; }
        #chat-thread::-webkit-scrollbar-thumb { background: #ced4da; border-radius: 10px; }

        #chatModalTitle span.badge { font-size: 0.8rem; vertical-align: middle; }
    </style>
@endpush

@section('content')

    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-12">
                <a href="{{ route('admin.dashboard') }}">
                    <button class="btn btn-primary">
                        <i class="fe fe-16 fe-arrow-left"></i> Back
                    </button>
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class="page-title">Chatbot Sessions (<span id="totalChatsCount"></span>)</h3>
            </div>
        </div>
    </div>

    <div class="container-fluid mb-4">
        <table id="chatsTable" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th><b class="h5">#</b></th>
                    <th><b class="h5">Visitor</b></th>
                    <th><b class="h5">First Message</b></th>
                    <th><b class="h5">Last Message</b></th>
                    <th><b class="h5">Msgs</b></th>
                    <th><b class="h5">Started</b></th>
                    <th><b class="h5">Last Active</b></th>
                    <th><b class="h5">Status</b></th>
                    <th><b class="h5">Action</b></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    {{-- ── Chat Thread Modal ─────────────────────────────────────── --}}
    <div class="modal fade" id="chatModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="chatModalTitle">Conversation</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body p-3">
                    {{-- Meta info --}}
                    <div id="chat-meta" class="mb-3 small text-muted"></div>

                    {{-- Thread --}}
                    <div id="chat-thread">
                        <div id="chat-loading" class="text-center py-3">
                            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                            <span class="ml-2">Loading conversation…</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {

            // ── DataTable ─────────────────────────────────────────
            var table = $('#chatsTable').DataTable({
                processing: true,
                serverSide: true,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                pageLength: 10,
                ordering: false,
                ajax: {
                    url: "{{ route('admin.fetch-chats') }}",
                    data: function (d) { d._token = "{{ csrf_token() }}"; },
                    dataSrc: function (json) {
                        $('#totalChatsCount').text(json.recordsTotal);
                        return json.data;
                    }
                },
                columns: [
                    { data: 'DT_RowIndex',    name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'visitor',         name: 'visitor',     orderable: false },
                    { data: 'first_message',   name: 'first_message', orderable: false },
                    { data: 'last_message',    name: 'last_message',  orderable: false },
                    { data: 'messages_count',  name: 'messages_count', orderable: false, searchable: false },
                    { data: 'started_at',      name: 'started_at' },
                    { data: 'last_active_at',  name: 'last_active_at' },
                    { data: 'status',          name: 'status', orderable: false, searchable: false },
                    { data: 'actions',         name: 'actions', orderable: false, searchable: false },
                ],
            });

            // ── View Chat Button ──────────────────────────────────
            $(document).on('click', '.view-chat-btn', function (e) {
                e.stopPropagation();
                var id = $(this).data('id');
                openChatModal(id);
            });

            // ── Open Modal & Fetch Messages ───────────────────────
            function openChatModal(sessionId) {
                // Reset
                $('#chat-thread').html(
                    '<div id="chat-loading" class="text-center py-3">' +
                    '<div class="spinner-border spinner-border-sm text-primary" role="status"></div>' +
                    '<span class="ml-2">Loading conversation…</span></div>'
                );
                $('#chatModalTitle').text('Conversation');
                $('#chat-meta').html('');
                $('#chatModal').modal('show');

                $.ajax({
                    url: '/admin/chats/' + sessionId + '/messages',
                    type: 'GET',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (data) {
                        renderThread(data);
                    },
                    error: function () {
                        $('#chat-thread').html('<p class="text-danger text-center">Failed to load conversation.</p>');
                    }
                });
            }

            // ── Render Thread ─────────────────────────────────────
            function escapeHtml(str) {
                return String(str)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;');
            }

            function renderThread(data) {
                $('#chatModalTitle').html(
                    'Conversation with <strong>' + escapeHtml(data.visitor_name) + '</strong>'
                );

                $('#chat-meta').html(
                    '<i class="fe fe-clock fe-12"></i> Started: <strong>' + data.started_at + '</strong>' +
                    ' &nbsp;|&nbsp; <i class="fe fe-message-circle fe-12"></i> ' + data.messages.length + ' messages'
                );

                if (!data.messages || data.messages.length === 0) {
                    $('#chat-thread').html('<p class="text-muted text-center">No messages found.</p>');
                    return;
                }

                var html = '';
                data.messages.forEach(function (msg) {
                    var isUser = msg.role === 'user';
                    var rowClass = isUser ? 'user' : 'assistant';
                    var label    = isUser ? 'Visitor' : 'UV';

                    // Server replies may have HTML links — render as-is for assistant
                    // Escape user messages to prevent XSS
                    var content = isUser
                        ? escapeHtml(msg.content).replace(/\n/g, '<br>')
                        : msg.content.replace(/\n/g, '<br>');

                    html += '<div class="chat-bubble-row ' + rowClass + '">' +
                                '<div class="chat-role-label">' + label + '</div>' +
                                '<div class="chat-bubble">' +
                                    content +
                                    '<span class="chat-bubble-time">' + msg.sent_at + '</span>' +
                                '</div>' +
                            '</div>';
                });

                $('#chat-thread').html(html);

                // Scroll to bottom of thread
                var thread = document.getElementById('chat-thread');
                thread.scrollTop = thread.scrollHeight;
            }

        });
    </script>
@endpush